<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('reference_id', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('area_locality', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }
        if ($request->filled('agent_id')) {
            $query->where('user_id', $request->agent_id);
        }

        $properties = $query->with('user')->latest()->paginate(10);
        $agents = User::where('role', 'agent')->orWhere('role', 'admin')->get();

        return view('admin.properties.index', compact('properties', 'agents'));
    }

    public function create()
    {
        $agents = User::where('role', 'agent')->orWhere('role', 'admin')->get();
        $countries = \App\Models\Location::where('type', 'Country')->where('status', 'Active')->get();
        $propertyTypes = \App\Models\PropertyType::where('status', 'Active')->get();
        $amenitiesList = \App\Models\Amenity::where('status', 'Active')->get();
        return view('admin.properties.create', compact('agents', 'countries', 'propertyTypes', 'amenitiesList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'property_category' => 'required|string',
            'property_type' => 'required|string',
            'property_type_id' => 'nullable|exists:property_types,id',
            'purpose' => 'required|in:buy,rent',
            'price' => 'required|numeric',
            'price_unit' => 'nullable|string',
            'area' => 'required|numeric',
            'area_unit' => 'required|string',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|numeric',
            'description' => 'nullable|string',
            'city' => 'required|string',
            'area_locality' => 'required|string',
            'location_id' => 'nullable|exists:locations,id',
            'address' => 'nullable|string',
            'contact_name' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|email',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'is_featured' => 'boolean',
            'amenities_ids' => 'nullable|array',
            'amenities_ids.*' => 'exists:amenities,id',
            'images.*' => 'nullable|image|max:5120'
        ]);

        $property = new Property($validated);
        
        $property->reference_id = 'PROP-' . strtoupper(Str::random(8));
        $property->slug = Str::slug($request->title) . '-' . time();
        $property->is_featured = $request->has('is_featured');
        
        // Sync amenities names for legacy support
        $amenitiesNames = [];
        if($request->has('amenities_ids') && is_array($request->amenities_ids)) {
            $amenitiesNames = \App\Models\Amenity::whereIn('id', $request->amenities_ids)->pluck('name')->toArray();
        }
        $property->amenities = $amenitiesNames;

        // Handle Image Uploads
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $imagePaths[] = $path;
            }
            $property->images = $imagePaths;
        }

        $property->save();
        
        if($request->has('amenities_ids')) {
            $property->amenitiesRelation()->sync($request->amenities_ids);
        }

        return redirect()->route('admin.properties.index')->with('success', 'Property created successfully.');
    }

    public function show(Property $property)
    {
        $property->load('user', 'amenitiesRelation');
        return view('admin.properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $agents = User::where('role', 'agent')->orWhere('role', 'admin')->get();
        $countries = \App\Models\Location::where('type', 'Country')->where('status', 'Active')->get();
        $propertyTypes = \App\Models\PropertyType::where('status', 'Active')->get();
        $amenitiesList = \App\Models\Amenity::where('status', 'Active')->get();
        return view('admin.properties.edit', compact('property', 'agents', 'countries', 'propertyTypes', 'amenitiesList'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'property_category' => 'required|string',
            'property_type' => 'required|string',
            'property_type_id' => 'nullable|exists:property_types,id',
            'purpose' => 'required|in:buy,rent',
            'price' => 'required|numeric',
            'price_unit' => 'nullable|string',
            'area' => 'required|numeric',
            'area_unit' => 'required|string',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|numeric',
            'description' => 'nullable|string',
            'city' => 'required|string',
            'area_locality' => 'required|string',
            'location_id' => 'nullable|exists:locations,id',
            'address' => 'nullable|string',
            'contact_name' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|email',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'is_featured' => 'boolean',
            'amenities_ids' => 'nullable|array',
            'amenities_ids.*' => 'exists:amenities,id',
            'images.*' => 'nullable|image|max:5120'
        ]);

        $property->fill($validated);
        
        if ($property->isDirty('title')) {
            $property->slug = Str::slug($request->title) . '-' . time();
        }
        
        $property->is_featured = $request->has('is_featured');
        
        // Sync amenities names for legacy support
        $amenitiesNames = [];
        if($request->has('amenities_ids') && is_array($request->amenities_ids)) {
            $amenitiesNames = \App\Models\Amenity::whereIn('id', $request->amenities_ids)->pluck('name')->toArray();
        }
        $property->amenities = $amenitiesNames;

        // Handle Image Uploads
        if ($request->hasFile('images')) {
            $imagePaths = $property->images ?? [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $imagePaths[] = $path;
            }
            $property->images = $imagePaths;
        }

        $property->save();

        if($request->has('amenities_ids')) {
            $property->amenitiesRelation()->sync($request->amenities_ids);
        } else {
            $property->amenitiesRelation()->sync([]);
        }

        return redirect()->route('admin.properties.index')->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        // Images are soft deleted along with property, or we can choose to delete from storage if we want hard delete
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success', 'Property deleted successfully.');
    }

    public function toggleFeatured(Request $request, Property $property)
    {
        $property->is_featured = !$property->is_featured;
        $property->save();
        
        return response()->json([
            'success' => true,
            'is_featured' => $property->is_featured,
            'message' => 'Property featured status updated.'
        ]);
    }
    
    public function deleteImage(Request $request, Property $property)
    {
        $imagePath = $request->image_path;
        $images = $property->images ?? [];
        
        if (($key = array_search($imagePath, $images)) !== false) {
            unset($images[$key]);
            $property->images = array_values($images);
            $property->save();
            
            Storage::disk('public')->delete($imagePath);
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
}
