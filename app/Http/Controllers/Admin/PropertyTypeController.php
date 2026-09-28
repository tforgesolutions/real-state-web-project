<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = PropertyType::withCount('properties');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $propertyTypes = $query->latest()->paginate(15);

        return view('admin.property-types.index', compact('propertyTypes'));
    }

    public function create()
    {
        return view('admin.property-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:property_types,name',
            'slug' => 'nullable|string|max:255|unique:property_types,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
            // Ensure unique slug
            $original = $data['slug'];
            $count = 1;
            while(PropertyType::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $original . '-' . $count++;
            }
        }

        PropertyType::create($data);

        return redirect()->route('admin.property-types.index')->with('success', 'Property Type created successfully.');
    }

    public function show(PropertyType $propertyType)
    {
        $propertyType->loadCount('properties');
        $properties = $propertyType->properties()->latest()->take(10)->get();
        return view('admin.property-types.show', compact('propertyType', 'properties'));
    }

    public function edit(PropertyType $propertyType)
    {
        return view('admin.property-types.edit', compact('propertyType'));
    }

    public function update(Request $request, PropertyType $propertyType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:property_types,name,'.$propertyType->id,
            'slug' => 'nullable|string|max:255|unique:property_types,slug,'.$propertyType->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
            // Ensure unique slug
            $original = $data['slug'];
            $count = 1;
            while(PropertyType::where('slug', $data['slug'])->where('id', '!=', $propertyType->id)->exists()) {
                $data['slug'] = $original . '-' . $count++;
            }
        }

        $propertyType->update($data);

        return redirect()->route('admin.property-types.index')->with('success', 'Property Type updated successfully.');
    }

    public function destroy(PropertyType $propertyType)
    {
        if ($propertyType->properties()->count() > 0) {
            return back()->with('error', 'Cannot delete this property type because it is in use by properties.');
        }

        $propertyType->delete();

        return redirect()->route('admin.property-types.index')->with('success', 'Property Type deleted successfully.');
    }
}
