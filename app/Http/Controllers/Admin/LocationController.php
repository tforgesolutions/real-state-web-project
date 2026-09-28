<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::with('parent')->withCount(['properties', 'projects']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $locations = $query->latest()->paginate(15);

        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        $countries = Location::where('type', 'Country')->get();
        $states = Location::where('type', 'Province/State')->get();
        $cities = Location::where('type', 'City')->get();
        
        return view('admin.locations.create', compact('countries', 'states', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:Country,Province/State,City,Area/Locality',
            'parent_id' => [
                'nullable',
                'exists:locations,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->type !== 'Country' && empty($value)) {
                        $fail('A parent location is required for this location type.');
                    }
                }
            ],
            'status' => 'required|in:Active,Inactive',
            'description' => 'nullable|string'
        ]);

        // Duplicate check
        $exists = Location::where('name', $request->name)
            ->where('type', $request->type)
            ->where('parent_id', $request->parent_id)
            ->exists();
            
        if ($exists) {
            return back()->withInput()->with('error', 'A location with this name already exists under the selected parent.');
        }

        Location::create($request->all());

        return redirect()->route('admin.locations.index')->with('success', 'Location created successfully.');
    }

    public function show(Location $location)
    {
        $location->load(['parent', 'children']);
        $location->loadCount(['properties', 'projects']);
        
        return view('admin.locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        $countries = Location::where('type', 'Country')->where('id', '!=', $location->id)->get();
        $states = Location::where('type', 'Province/State')->where('id', '!=', $location->id)->get();
        $cities = Location::where('type', 'City')->where('id', '!=', $location->id)->get();
        
        return view('admin.locations.edit', compact('location', 'countries', 'states', 'cities'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:Country,Province/State,City,Area/Locality',
            'parent_id' => [
                'nullable',
                'exists:locations,id',
                function ($attribute, $value, $fail) use ($request, $location) {
                    if ($request->type !== 'Country' && empty($value)) {
                        $fail('A parent location is required for this location type.');
                    }
                    if ($value == $location->id) {
                        $fail('A location cannot be its own parent.');
                    }
                    // Prevent circular dependency simple check
                    $parent = Location::find($value);
                    if ($parent && $parent->parent_id == $location->id) {
                        $fail('Circular relationship detected.');
                    }
                }
            ],
            'status' => 'required|in:Active,Inactive',
            'description' => 'nullable|string'
        ]);
        
        // Duplicate check
        $exists = Location::where('name', $request->name)
            ->where('type', $request->type)
            ->where('parent_id', $request->parent_id)
            ->where('id', '!=', $location->id)
            ->exists();
            
        if ($exists) {
            return back()->withInput()->with('error', 'A location with this name already exists under the selected parent.');
        }

        $location->update($request->all());

        return redirect()->route('admin.locations.index')->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        if ($location->children()->count() > 0) {
            return back()->with('error', 'Cannot delete this location because it has child locations.');
        }

        if ($location->properties()->count() > 0) {
            return back()->with('error', 'Cannot delete this location because it is assigned to properties.');
        }

        if ($location->projects()->count() > 0) {
            return back()->with('error', 'Cannot delete this location because it is assigned to projects.');
        }

        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Location deleted successfully.');
    }
    
    // API endpoint for dynamic dropdowns
    public function getChildren(Location $location)
    {
        return response()->json($location->children()->where('status', 'Active')->get(['id', 'name']));
    }
}
