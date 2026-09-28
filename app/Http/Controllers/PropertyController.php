<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PropertyController extends Controller
{
    use AuthorizesRequests;

    public function create()
    {
        return view('properties.create');
    }

    public function store(Request $request)
    {
        $isDraft = $request->input('is_draft');

        $rules = [
            'purpose' => $isDraft ? 'nullable|in:buy,rent' : 'required|in:buy,rent',
            'property_category' => $isDraft ? 'nullable|string' : 'required|string',
            'property_type' => $isDraft ? 'nullable|string' : 'required|string',
            'title' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|numeric|min:0',
            'area' => $isDraft ? 'nullable|numeric|min:1' : 'required|numeric|min:1',
            'area_unit' => $isDraft ? 'nullable|string' : 'required|string',
            'furnished' => 'nullable|string',
            'condition' => 'nullable|string',
            'parking' => 'nullable|string',
            'construction_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'country' => 'nullable|string',
            'city' => $isDraft ? 'nullable|string' : 'required|string',
            'area_locality' => $isDraft ? 'nullable|string' : 'required|string',
            'society' => 'nullable|string',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'price' => $isDraft ? 'nullable|numeric|min:1' : 'required|numeric|min:1',
            'price_unit' => 'nullable|string',
            'negotiable' => 'nullable|boolean',
            'description' => 'nullable|string|max:5000',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'video_url' => 'nullable|url',
            'virtual_tour_url' => 'nullable|url',
            'floor_plan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'contact_name' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'contact_phone' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'contact_email' => $isDraft ? 'nullable|email|max:255' : 'required|email|max:255',
            'contact_whatsapp' => 'nullable|string|max:255',
            'preferred_contact_method' => $isDraft ? 'nullable|string' : 'required|string',
            'is_draft' => 'nullable|boolean'
        ];

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            $property = new Property($validated);
            $property->user_id = auth()->id();
            $property->reference_id = 'PROP-' . strtoupper(Str::random(6));
            
            // Handle defaults for draft if missing
            $property->title = $property->title ?? 'Draft Property';
            $property->city = $property->city ?? 'Unknown';
            $property->area = $property->area ?? 0;
            $property->area_unit = $property->area_unit ?? 'Sq Ft';
            $property->purpose = $property->purpose ?? 'buy';
            $property->property_category = $property->property_category ?? 'Residential';
            $property->property_type = $property->property_type ?? 'House';
            $property->area_locality = $property->area_locality ?? 'Unknown';
            $property->price = $property->price ?? 0;
            $property->contact_name = $property->contact_name ?? auth()->user()->name;
            $property->contact_phone = $property->contact_phone ?? 'Unknown';
            $property->contact_email = $property->contact_email ?? auth()->user()->email;
            
            // Generate unique slug
            $baseSlug = Str::slug($property->title . '-' . $property->city);
            $slug = $baseSlug;
            $counter = 1;
            while(Property::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $property->slug = $slug;

            // Determine status
            $property->status = $request->input('is_draft') ? 'draft' : 'pending_review';
            
            // Handle Images
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('properties', 'public');
                }
            }
            $property->images = $imagePaths;
            
            // Handle Floor Plan
            if ($request->hasFile('floor_plan')) {
                $property->floor_plan_image = $request->file('floor_plan')->store('floor_plans', 'public');
            }

            $property->save();

            DB::commit();

            return redirect()->route('properties.success', $property);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'There was an error saving your property: ' . $e->getMessage());
        }
    }

    public function success(Property $property)
    {
        $this->authorize('view', $property);
        return view('properties.success', compact('property'));
    }

    public function myProperties(Request $request)
    {
        $status = $request->query('status', 'all');
        
        $query = Property::where('user_id', auth()->id())->latest();
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $properties = $query->paginate(10)->withQueryString();
        
        return view('account.my-properties.index', compact('properties', 'status'));
    }

    public function edit(Property $property)
    {
        $this->authorize('update', $property);
        return view('account.my-properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);
        
        $validated = $request->validate([
            // Step 1
            'purpose' => 'required|in:buy,rent',
            'property_category' => 'required|string',
            'property_type' => 'required|string',
            
            // Step 2
            'title' => 'required|string|max:255',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|numeric|min:0',
            'area' => 'required|numeric|min:1',
            'area_unit' => 'required|string',
            'furnished' => 'nullable|string',
            'condition' => 'nullable|string',
            'parking' => 'nullable|string',
            'construction_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            
            // Step 3
            'country' => 'nullable|string',
            'city' => 'required|string',
            'area_locality' => 'required|string',
            'society' => 'nullable|string',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
            
            // Step 4
            'price' => 'required|numeric|min:1',
            'price_unit' => 'nullable|string',
            'negotiable' => 'nullable|boolean',
            'description' => 'nullable|string|max:5000',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            
            // Step 5 (Media)
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'video_url' => 'nullable|url',
            'virtual_tour_url' => 'nullable|url',
            'floor_plan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            
            // Step 6 (Contact)
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_whatsapp' => 'nullable|string|max:255',
            'preferred_contact_method' => 'required|string',
            
            // Draft
            'is_draft' => 'nullable|boolean'
        ]);

        try {
            DB::beginTransaction();

            $property->fill($validated);
            
            if ($property->isDirty('title') || $property->isDirty('city')) {
                // Generate unique slug
                $baseSlug = Str::slug($validated['title'] . '-' . $validated['city']);
                $slug = $baseSlug;
                $counter = 1;
                while(Property::where('slug', $slug)->where('id', '!=', $property->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                $property->slug = $slug;
            }

            // Materially changed approved property goes back to pending review unless saved as draft
            if ($property->status === 'approved' && $property->isDirty()) {
                $property->status = 'pending_review';
            }
            
            if ($request->input('is_draft')) {
                $property->status = 'draft';
            } elseif ($property->status === 'draft') {
                $property->status = 'pending_review';
            }
            
            // Handle Images (Append new images to existing)
            $imagePaths = $property->images ?? [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('properties', 'public');
                }
                $property->images = $imagePaths;
            }
            
            // Handle Floor Plan
            if ($request->hasFile('floor_plan')) {
                // Delete old floor plan if exists
                if ($property->floor_plan_image) {
                    Storage::disk('public')->delete($property->floor_plan_image);
                }
                $property->floor_plan_image = $request->file('floor_plan')->store('floor_plans', 'public');
            }

            $property->save();

            DB::commit();

            return redirect()->route('account.my-properties.index')->with('success', 'Property updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'There was an error updating your property: ' . $e->getMessage());
        }
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        $property->delete();
        return redirect()->route('account.my-properties.index')->with('success', 'Property withdrawn successfully.');
    }
}
