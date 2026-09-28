<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('reference_id', 'like', "%{$search}%")
                  ->orWhere('developer', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->filled('project_type')) {
            $query->where('project_type', $request->project_type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }

        $projects = $query->latest()->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $countries = \App\Models\Location::where('type', 'Country')->where('status', 'Active')->get();
        return view('admin.projects.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'developer' => 'required|string|max:255',
            'project_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'location_id' => 'nullable|exists:locations,id',
            'address' => 'nullable|string|max:255',
            'total_units' => 'nullable|integer|min:0',
            'available_units' => 'nullable|integer|min:0',
            'sold_units' => 'nullable|integer|min:0',
            'starting_price' => 'nullable|numeric|min:0',
            'maximum_price' => 'nullable|numeric|min:0',
            'completion_date' => 'nullable|date',
            'status' => 'required|string',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'website_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'amenities' => 'nullable|array',
            'images.*' => 'nullable|image|max:5120'
        ]);

        $project = new Project($validated);
        
        $project->reference_id = 'PRJ-' . strtoupper(Str::random(8));
        $project->slug = Str::slug($request->title) . '-' . time();
        $project->is_featured = $request->has('is_featured');
        $project->amenities = $request->amenities ?? [];

        // Handle Image Uploads
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('projects', 'public');
                $imagePaths[] = $path;
            }
            $project->images = $imagePaths;
        }

        $project->save();

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $countries = \App\Models\Location::where('type', 'Country')->where('status', 'Active')->get();
        return view('admin.projects.edit', compact('project', 'countries'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'developer' => 'required|string|max:255',
            'project_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'location_id' => 'nullable|exists:locations,id',
            'address' => 'nullable|string|max:255',
            'total_units' => 'nullable|integer|min:0',
            'available_units' => 'nullable|integer|min:0',
            'sold_units' => 'nullable|integer|min:0',
            'starting_price' => 'nullable|numeric|min:0',
            'maximum_price' => 'nullable|numeric|min:0',
            'completion_date' => 'nullable|date',
            'status' => 'required|string',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'website_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'amenities' => 'nullable|array',
            'images.*' => 'nullable|image|max:5120'
        ]);

        $project->fill($validated);
        
        if ($project->isDirty('title')) {
            $project->slug = Str::slug($request->title) . '-' . time();
        }
        
        $project->is_featured = $request->has('is_featured');
        $project->amenities = $request->amenities ?? [];

        // Handle Image Uploads
        if ($request->hasFile('images')) {
            $imagePaths = $project->images ?? [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('projects', 'public');
                $imagePaths[] = $path;
            }
            $project->images = $imagePaths;
        }

        $project->save();

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    public function toggleFeatured(Request $request, Project $project)
    {
        $project->is_featured = !$project->is_featured;
        $project->save();
        
        return response()->json([
            'success' => true,
            'is_featured' => $project->is_featured,
            'message' => 'Project featured status updated.'
        ]);
    }
    
    public function deleteImage(Request $request, Project $project)
    {
        $imagePath = $request->image_path;
        $images = $project->images ?? [];
        
        if (($key = array_search($imagePath, $images)) !== false) {
            unset($images[$key]);
            $project->images = array_values($images);
            $project->save();
            
            Storage::disk('public')->delete($imagePath);
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
}
