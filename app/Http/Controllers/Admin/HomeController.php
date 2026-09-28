<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.homepage.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Hero
            'home_hero_title' => 'nullable|string|max:255',
            'home_hero_subtitle' => 'nullable|string|max:1000',
            'home_hero_button_text' => 'nullable|string|max:100',
            'home_hero_button_link' => 'nullable|string|max:255',
            'home_hero_bg' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            
            // Toggles
            'show_home_hero' => 'nullable|boolean',
            'show_home_search' => 'nullable|boolean',
            'show_featured_properties' => 'nullable|boolean',
            'show_featured_projects' => 'nullable|boolean',
            'show_featured_agents' => 'nullable|boolean',
            'show_home_cta' => 'nullable|boolean',
            
            // Headings
            'home_featured_heading' => 'nullable|string|max:255',
            'home_projects_heading' => 'nullable|string|max:255',
            'home_agents_heading' => 'nullable|string|max:255',
            
            // CTA
            'home_cta_heading' => 'nullable|string|max:255',
            'home_cta_subtitle' => 'nullable|string|max:1000',
            'home_cta_button_text' => 'nullable|string|max:100',
            'home_cta_button_link' => 'nullable|string|max:255',
        ]);

        // Process File Uploads
        if ($request->hasFile('home_hero_bg')) {
            $path = $request->file('home_hero_bg')->store('homepage', 'public');
            Setting::set('home_hero_bg', $path, 'image');
        }

        // Checkboxes defaults
        $toggles = [
            'show_home_hero', 'show_home_search', 
            'show_featured_properties', 'show_featured_projects', 
            'show_featured_agents', 'show_home_cta'
        ];
        
        foreach ($toggles as $toggle) {
            Setting::set($toggle, $request->has($toggle) ? '1' : '0', 'boolean');
        }

        // Text fields
        $textFields = [
            'home_hero_title', 'home_hero_subtitle', 'home_hero_button_text', 'home_hero_button_link',
            'home_featured_heading', 'home_projects_heading', 'home_agents_heading',
            'home_cta_heading', 'home_cta_subtitle', 'home_cta_button_text', 'home_cta_button_link'
        ];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                Setting::set($field, $validated[$field] ?? '', 'text');
            }
        }

        return redirect()->back()->with('success', 'Homepage settings updated successfully.');
    }
}
