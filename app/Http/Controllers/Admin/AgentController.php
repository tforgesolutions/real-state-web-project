<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'agent');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('agency', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }
        if ($request->filled('agency')) {
            $query->where('agency', $request->agency);
        }

        // withCount properties
        $agents = $query->withCount('properties')->latest()->paginate(10);
        
        $agencies = User::where('role', 'agent')->whereNotNull('agency')->distinct()->pluck('agency');

        return view('admin.agents.index', compact('agents', 'agencies'));
    }

    public function create()
    {
        return view('admin.agents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'agency' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive,suspended',
            'is_featured' => 'boolean',
            'profile_photo' => 'nullable|image|max:2048'
        ]);
        
        // Agent does not have a real login as per instructions unless needed.
        // We will assign a random password and set role to 'agent'.
        $validated['password'] = bcrypt(Str::random(16));
        $validated['role'] = 'agent';
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('agents', 'public');
        }

        User::create($validated);

        return redirect()->route('admin.agents.index')->with('success', 'Agent created successfully.');
    }

    public function show(User $agent)
    {
        abort_if($agent->role !== 'agent', 404);
        
        $properties = $agent->properties()->latest()->paginate(10);
        
        return view('admin.agents.show', compact('agent', 'properties'));
    }

    public function edit(User $agent)
    {
        abort_if($agent->role !== 'agent', 404);
        return view('admin.agents.edit', compact('agent'));
    }

    public function update(Request $request, User $agent)
    {
        abort_if($agent->role !== 'agent', 404);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $agent->id,
            'phone' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'agency' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive,suspended',
            'is_featured' => 'boolean',
            'profile_photo' => 'nullable|image|max:2048'
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('profile_photo')) {
            if ($agent->profile_photo) {
                Storage::disk('public')->delete($agent->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('agents', 'public');
        }

        $agent->update($validated);

        return redirect()->route('admin.agents.index')->with('success', 'Agent updated successfully.');
    }

    public function destroy(User $agent)
    {
        abort_if($agent->role !== 'agent', 404);
        
        if ($agent->properties()->count() > 0) {
            return redirect()->route('admin.agents.index')->with('error', 'Cannot delete agent because they have assigned properties. Please reassign the properties first.');
        }

        if ($agent->profile_photo) {
            Storage::disk('public')->delete($agent->profile_photo);
        }

        $agent->delete();
        
        return redirect()->route('admin.agents.index')->with('success', 'Agent deleted successfully.');
    }

    public function toggleFeatured(Request $request, User $agent)
    {
        abort_if($agent->role !== 'agent', 404);
        
        $agent->is_featured = !$agent->is_featured;
        $agent->save();
        
        return response()->json([
            'success' => true,
            'is_featured' => $agent->is_featured,
            'message' => 'Agent featured status updated.'
        ]);
    }
    
    public function removePhoto(Request $request, User $agent)
    {
        abort_if($agent->role !== 'agent', 404);
        
        if ($agent->profile_photo) {
            Storage::disk('public')->delete($agent->profile_photo);
            $agent->profile_photo = null;
            $agent->save();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
}
