<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Property;
use App\Models\Project;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query()->with('uploader');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        // Filter Type
        if ($request->filled('type')) {
            if ($request->type === 'image') {
                $query->where('mime_type', 'like', 'image/%');
            } elseif ($request->type === 'document') {
                $query->where('mime_type', 'not like', 'image/%');
            }
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        if ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'largest') {
            $query->orderBy('file_size', 'desc');
        } elseif ($sort === 'name') {
            $query->orderBy('original_name', 'asc');
        }

        $media = $query->paginate(24)->withQueryString();
        
        // Add usage info for the current page only to avoid N+1 over all data
        foreach ($media as $item) {
            $item->usage = $this->checkUsage($item->file_path);
        }

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,png,jpg,webp|max:10240' // 10MB max
        ]);

        if (!$request->hasFile('files')) {
            return redirect()->back()->withErrors(['files' => 'No files were uploaded.']);
        }

        $uploadedCount = 0;

        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());
            $mimeType = $file->getClientMimeType();
            $size = $file->getSize();
            
            // Dangerous extensions check
            if (in_array($extension, ['php', 'exe', 'js', 'sh', 'bat', 'html', 'phtml'])) {
                continue; // Skip dangerous files
            }

            // Secure filename
            $filename = Str::random(40) . '.' . $extension;
            
            // Store file
            $path = $file->storeAs('media/' . date('Y/m'), $filename, 'public');
            
            // Image dimensions if it's an image
            $width = null;
            $height = null;
            if (str_starts_with($mimeType, 'image/')) {
                $imageSize = @getimagesize($file->getPathname());
                if ($imageSize) {
                    $width = $imageSize[0];
                    $height = $imageSize[1];
                }
            }

            Media::create([
                'file_name' => $filename,
                'original_name' => $originalName,
                'file_path' => $path,
                'mime_type' => $mimeType,
                'file_size' => $size,
                'width' => $width,
                'height' => $height,
                'disk' => 'public',
                'uploaded_by' => auth()->id(),
            ]);
            
            $uploadedCount++;
        }

        return redirect()->back()->with('success', "Successfully uploaded {$uploadedCount} file(s).");
    }

    public function destroy(Media $media)
    {
        $usage = $this->checkUsage($media->file_path);
        
        if (count($usage) > 0) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete media. It is currently in use by ' . count($usage) . ' record(s).']);
        }

        // Delete physical file
        if (Storage::disk($media->disk)->exists($media->file_path)) {
            Storage::disk($media->disk)->delete($media->file_path);
        }

        $media->delete();

        return redirect()->back()->with('success', 'Media deleted successfully.');
    }

    public function sync(Request $request)
    {
        $allFiles = Storage::disk('public')->allFiles();
        $added = 0;
        
        $existingPaths = Media::pluck('file_path')->toArray();
        
        foreach ($allFiles as $path) {
            // Exclude livewire temp or non-media folders if needed
            if (str_starts_with($path, 'livewire-tmp')) continue;
            
            if (!in_array($path, $existingPaths)) {
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp'])) {
                    $size = Storage::disk('public')->size($path);
                    $mimeType = Storage::disk('public')->mimeType($path);
                    
                    Media::create([
                        'file_name' => basename($path),
                        'original_name' => basename($path),
                        'file_path' => $path,
                        'mime_type' => $mimeType ?: 'image/jpeg',
                        'file_size' => $size,
                        'disk' => 'public',
                        'uploaded_by' => auth()->id() ?? 1,
                    ]);
                    $added++;
                }
            }
        }
        
        return redirect()->back()->with('success', "Synced {$added} new files from storage into the Media Library.");
    }

    private function checkUsage($path)
    {
        $usages = [];
        $searchQuery = '%"' . $path . '"%';
        $exactPath = $path;

        // 1. Check Properties (JSON array of images)
        $properties = Property::where('images', 'LIKE', $searchQuery)->get();
        foreach ($properties as $prop) {
            $usages[] = "Property: " . $prop->title;
        }

        // 2. Check Projects (JSON array of images)
        $projects = Project::where('images', 'LIKE', $searchQuery)->get();
        foreach ($projects as $proj) {
            $usages[] = "Project: " . $proj->title;
        }

        // 3. Check Agents/Users (exact path)
        $users = User::where('profile_photo', $exactPath)->get();
        foreach ($users as $u) {
            $usages[] = "User/Agent: " . $u->name;
        }

        // 4. Check Settings (exact path)
        $settings = Setting::where('value', $exactPath)->get();
        foreach ($settings as $setting) {
            $usages[] = "Setting: " . $setting->key;
        }

        return $usages;
    }
}
