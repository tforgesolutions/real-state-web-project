<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('testimonial', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('featured')) {
            $query->where('featured', $request->featured);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $query->orderBy('display_order', 'asc')->orderBy('created_at', 'desc');

        $testimonials = $query->paginate(15)->withQueryString();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'testimonial' => 'required|string|max:2000',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'display_order' => 'required|integer|min:0',
        ]);

        $validated['status'] = $request->has('status');
        $validated['featured'] = $request->has('featured');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('testimonials', $filename, 'public');
            $validated['image'] = $path;
            
            // Also store in Media Library for consistency if desired
            Media::create([
                'file_name' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'disk' => 'public',
                'uploaded_by' => auth()->id(),
            ]);
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'testimonial' => 'required|string|max:2000',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'display_order' => 'required|integer|min:0',
        ]);

        $validated['status'] = $request->has('status');
        $validated['featured'] = $request->has('featured');

        if ($request->hasFile('image')) {
            // Delete old image safely if not used elsewhere
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                $usageCount = \App\Models\Testimonial::where('image', $testimonial->image)->count();
                if ($usageCount <= 1) { // Only used by this testimonial
                    Storage::disk('public')->delete($testimonial->image);
                    Media::where('file_path', $testimonial->image)->delete();
                }
            }

            $file = $request->file('image');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('testimonials', $filename, 'public');
            $validated['image'] = $path;
            
            Media::create([
                'file_name' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'disk' => 'public',
                'uploaded_by' => auth()->id(),
            ]);
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
            $usageCount = \App\Models\Testimonial::where('image', $testimonial->image)->count();
            if ($usageCount <= 1) {
                Storage::disk('public')->delete($testimonial->image);
                Media::where('file_path', $testimonial->image)->delete();
            }
        }

        $testimonial->delete();

        return redirect()->back()->with('success', 'Testimonial deleted successfully.');
    }

    public function toggle(Testimonial $testimonial)
    {
        $testimonial->status = !$testimonial->status;
        $testimonial->save();
        
        return redirect()->back()->with('success', 'Testimonial status updated.');
    }

    public function feature(Testimonial $testimonial)
    {
        $testimonial->featured = !$testimonial->featured;
        $testimonial->save();
        
        return redirect()->back()->with('success', 'Testimonial featured status updated.');
    }
}
