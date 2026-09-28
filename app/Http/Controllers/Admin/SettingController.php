<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getAll();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // General
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'default_language' => 'nullable|string|max:10',
            'timezone' => 'nullable|string|max:100',
            'currency' => 'nullable|string|max:10',
            'date_format' => 'nullable|string|max:50',
            
            // Branding
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg|max:1024',
            
            // Contact
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'contact_whatsapp' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string',
            'contact_city' => 'nullable|string|max:100',
            'contact_country' => 'nullable|string|max:100',
            
            // Social Media
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            
            // SEO
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string',
            'seo_meta_keywords' => 'nullable|string',
            'seo_author' => 'nullable|string|max:255',
            
            // Features / Website
            'show_featured_properties' => 'nullable|boolean',
            'show_projects' => 'nullable|boolean',
            'show_agents' => 'nullable|boolean',
            
            // System
            'maintenance_mode' => 'nullable|boolean',
            'maintenance_message' => 'nullable|string',
        ]);

        $settings = $request->except(['_token', 'logo', 'favicon']);

        // Handle checkboxes (if not present in request, set to false)
        $checkboxes = ['show_featured_properties', 'show_projects', 'show_agents', 'maintenance_mode'];
        foreach ($checkboxes as $checkbox) {
            $settings[$checkbox] = $request->has($checkbox) ? '1' : '0';
        }

        // Handle Image Uploads
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            $settings['logo'] = $path;
            
            // Delete old logo if exists
            $oldLogo = Setting::get('logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
        }
        
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('settings', 'public');
            $settings['favicon'] = $path;
            
            $oldFavicon = Setting::get('favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
        }

        // Save all settings
        foreach ($settings as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value);
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
