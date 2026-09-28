<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AmenityController extends Controller
{
    public function index(Request $request)
    {
        $query = Amenity::withCount('properties');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $amenities = $query->latest()->paginate(15);

        return view('admin.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name',
            'slug' => 'nullable|string|max:255|unique:amenities,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
            // Ensure unique
            $original = $data['slug'];
            $count = 1;
            while(Amenity::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $original . '-' . $count++;
            }
        }

        Amenity::create($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity created successfully.');
    }

    public function show(Amenity $amenity)
    {
        $amenity->loadCount('properties');
        $properties = $amenity->properties()->latest()->take(10)->get();
        return view('admin.amenities.show', compact('amenity', 'properties'));
    }

    public function edit(Amenity $amenity)
    {
        return view('admin.amenities.edit', compact('amenity'));
    }

    public function update(Request $request, Amenity $amenity)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name,'.$amenity->id,
            'slug' => 'nullable|string|max:255|unique:amenities,slug,'.$amenity->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
            $original = $data['slug'];
            $count = 1;
            while(Amenity::where('slug', $data['slug'])->where('id', '!=', $amenity->id)->exists()) {
                $data['slug'] = $original . '-' . $count++;
            }
        }

        $amenity->update($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity updated successfully.');
    }

    public function destroy(Amenity $amenity)
    {
        if ($amenity->properties()->count() > 0) {
            return back()->with('error', 'Cannot delete this amenity because it is attached to properties.');
        }

        $amenity->delete();
        return redirect()->route('admin.amenities.index')->with('success', 'Amenity deleted successfully.');
    }
}
