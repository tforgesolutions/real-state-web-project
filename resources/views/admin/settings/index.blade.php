@extends('admin.layouts.app')

@section('title', 'System Settings')
@section('header', 'System Settings')

@section('content')

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-green-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if ($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500"></i>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar Navigation -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <nav class="flex flex-col settings-nav">
                    <a href="#general" class="px-4 py-3 text-sm font-medium text-blue-600 bg-blue-50 border-l-4 border-blue-600" onclick="switchTab(event, 'general', this)">
                        <i class="fas fa-cog w-5 text-center mr-2"></i> General
                    </a>
                    <a href="#branding" class="px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent" onclick="switchTab(event, 'branding', this)">
                        <i class="fas fa-paint-brush w-5 text-center mr-2"></i> Branding
                    </a>
                    <a href="#contact" class="px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent" onclick="switchTab(event, 'contact', this)">
                        <i class="fas fa-address-book w-5 text-center mr-2"></i> Contact Info
                    </a>
                    <a href="#social" class="px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent" onclick="switchTab(event, 'social', this)">
                        <i class="fas fa-share-alt w-5 text-center mr-2"></i> Social Media
                    </a>
                    <a href="#seo" class="px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent" onclick="switchTab(event, 'seo', this)">
                        <i class="fas fa-search w-5 text-center mr-2"></i> SEO Settings
                    </a>
                    <a href="#features" class="px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent" onclick="switchTab(event, 'features', this)">
                        <i class="fas fa-layer-group w-5 text-center mr-2"></i> Features / Visibility
                    </a>
                    <a href="#system" class="px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent" onclick="switchTab(event, 'system', this)">
                        <i class="fas fa-server w-5 text-center mr-2"></i> System / Maintenance
                    </a>
                </nav>
            </div>
        </div>

        <!-- Content Area -->
        <div class="md:col-span-3">
            
            <!-- GENERAL SETTINGS -->
            <div id="general" class="settings-section bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6 block">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-800">General Settings</h3>
                    <p class="text-sm text-gray-500">Basic information about your website.</p>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website Name</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Real Estate Website') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                        <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" placeholder="e.g. Find your dream home" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="site_description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                            <input type="text" name="currency" value="{{ old('currency', $settings['currency'] ?? 'USD') }}" placeholder="USD, EUR, AED" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                            <input type="text" name="timezone" value="{{ old('timezone', $settings['timezone'] ?? 'UTC') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                    </div>
                </div>
            </div>

            <!-- BRANDING SETTINGS -->
            <div id="branding" class="settings-section bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6 hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-800">Branding</h3>
                    <p class="text-sm text-gray-500">Logos and icons used across the site.</p>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website Logo</label>
                        @if(isset($settings['logo']) && $settings['logo'])
                        <div class="mb-3 p-4 bg-gray-50 rounded border flex items-center justify-center max-w-xs">
                            <img src="{{ Storage::url($settings['logo']) }}" alt="Logo" class="max-h-16">
                        </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        <p class="text-xs text-gray-500 mt-1">Recommended size: 250x80 pixels. PNG with transparent background.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
                        @if(isset($settings['favicon']) && $settings['favicon'])
                        <div class="mb-3 p-4 bg-gray-50 rounded border flex items-center justify-center max-w-xs">
                            <img src="{{ Storage::url($settings['favicon']) }}" alt="Favicon" class="max-h-8">
                        </div>
                        @endif
                        <input type="file" name="favicon" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        <p class="text-xs text-gray-500 mt-1">Recommended size: 32x32 pixels. ICO or PNG format.</p>
                    </div>
                </div>
            </div>

            <!-- CONTACT SETTINGS -->
            <div id="contact" class="settings-section bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6 hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-800">Contact Information</h3>
                    <p class="text-sm text-gray-500">Public contact details displayed on the website.</p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                            <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp'] ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea name="contact_address" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" name="contact_city" value="{{ old('contact_city', $settings['contact_city'] ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <input type="text" name="contact_country" value="{{ old('contact_country', $settings['contact_country'] ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SOCIAL MEDIA -->
            <div id="social" class="settings-section bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6 hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-800">Social Media Links</h3>
                    <p class="text-sm text-gray-500">Leave blank to hide the icon from the frontend.</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center">
                        <span class="bg-gray-100 text-gray-600 px-4 py-2 border border-gray-300 border-r-0 rounded-l-md w-32"><i class="fab fa-facebook mr-2"></i> Facebook</span>
                        <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}" class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="flex items-center">
                        <span class="bg-gray-100 text-gray-600 px-4 py-2 border border-gray-300 border-r-0 rounded-l-md w-32"><i class="fab fa-instagram mr-2"></i> Instagram</span>
                        <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="flex items-center">
                        <span class="bg-gray-100 text-gray-600 px-4 py-2 border border-gray-300 border-r-0 rounded-l-md w-32"><i class="fab fa-twitter mr-2"></i> Twitter/X</span>
                        <input type="url" name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}" class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="flex items-center">
                        <span class="bg-gray-100 text-gray-600 px-4 py-2 border border-gray-300 border-r-0 rounded-l-md w-32"><i class="fab fa-linkedin mr-2"></i> LinkedIn</span>
                        <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $settings['social_linkedin'] ?? '') }}" class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="flex items-center">
                        <span class="bg-gray-100 text-gray-600 px-4 py-2 border border-gray-300 border-r-0 rounded-l-md w-32"><i class="fab fa-youtube mr-2"></i> YouTube</span>
                        <input type="url" name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                </div>
            </div>

            <!-- SEO SETTINGS -->
            <div id="seo" class="settings-section bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6 hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-800">SEO Defaults</h3>
                    <p class="text-sm text-gray-500">Default meta tags for search engines.</p>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Meta Title</label>
                        <input type="text" name="seo_meta_title" value="{{ old('seo_meta_title', $settings['seo_meta_title'] ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Meta Description</label>
                        <textarea name="seo_meta_description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('seo_meta_description', $settings['seo_meta_description'] ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Meta Keywords</label>
                        <input type="text" name="seo_meta_keywords" value="{{ old('seo_meta_keywords', $settings['seo_meta_keywords'] ?? '') }}" placeholder="real estate, buy home, properties" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                        <input type="text" name="seo_author" value="{{ old('seo_author', $settings['seo_author'] ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                </div>
            </div>

            <!-- FEATURES / WEBSITE -->
            <div id="features" class="settings-section bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6 hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-800">Features & Visibility</h3>
                    <p class="text-sm text-gray-500">Toggle sections on the public frontend.</p>
                </div>
                <div class="p-6 space-y-4">
                    <label class="flex items-center p-3 bg-gray-50 rounded border border-gray-200 cursor-pointer hover:bg-gray-100 transition">
                        <input type="checkbox" name="show_featured_properties" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" {{ (isset($settings['show_featured_properties']) && $settings['show_featured_properties'] == '1') || !isset($settings['show_featured_properties']) ? 'checked' : '' }}>
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-700">Show Featured Properties Section</span>
                            <span class="block text-xs text-gray-500">Display the featured properties grid on the homepage.</span>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-3 bg-gray-50 rounded border border-gray-200 cursor-pointer hover:bg-gray-100 transition">
                        <input type="checkbox" name="show_projects" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" {{ (isset($settings['show_projects']) && $settings['show_projects'] == '1') || !isset($settings['show_projects']) ? 'checked' : '' }}>
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-700">Show Projects Section</span>
                            <span class="block text-xs text-gray-500">Display the new developments / projects block on the frontend.</span>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-3 bg-gray-50 rounded border border-gray-200 cursor-pointer hover:bg-gray-100 transition">
                        <input type="checkbox" name="show_agents" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" {{ (isset($settings['show_agents']) && $settings['show_agents'] == '1') || !isset($settings['show_agents']) ? 'checked' : '' }}>
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-700">Show Agents Section</span>
                            <span class="block text-xs text-gray-500">Display the real estate agents carousel/grid on the frontend.</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- SYSTEM / MAINTENANCE -->
            <div id="system" class="settings-section bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6 hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-800">System & Maintenance</h3>
                    <p class="text-sm text-gray-500">Advanced system controls.</p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="p-4 bg-yellow-50 rounded border border-yellow-200">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="maintenance_mode" value="1" class="rounded border-yellow-400 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200" {{ (isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == '1') ? 'checked' : '' }}>
                            <div class="ml-3">
                                <span class="block text-sm font-medium text-yellow-800">Enable Maintenance Mode</span>
                                <span class="block text-xs text-yellow-700">The public website will be temporarily disabled for visitors. Admins can still log in.</span>
                            </div>
                        </label>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Maintenance Message</label>
                        <textarea name="maintenance_message" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('maintenance_message', $settings['maintenance_message'] ?? 'We are currently performing scheduled maintenance. Please check back soon.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Save Button (Sticky Footer) -->
            <div class="bg-gray-50 px-6 py-4 rounded-lg border border-gray-200 flex justify-end sticky bottom-6 shadow-sm">
                <button type="submit" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-6 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2 mt-0.5"></i> Save Settings
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    function switchTab(event, tabId, element) {
        event.preventDefault();
        
        // Hide all sections
        document.querySelectorAll('.settings-section').forEach(function(el) {
            el.classList.add('hidden');
            el.classList.remove('block');
        });
        
        // Show target section
        document.getElementById(tabId).classList.remove('hidden');
        document.getElementById(tabId).classList.add('block');
        
        // Reset navigation styles
        document.querySelectorAll('.settings-nav a').forEach(function(el) {
            el.classList.remove('text-blue-600', 'bg-blue-50', 'border-blue-600');
            el.classList.add('text-gray-600', 'hover:bg-gray-50', 'border-transparent');
        });
        
        // Active navigation style
        element.classList.remove('text-gray-600', 'hover:bg-gray-50', 'border-transparent');
        element.classList.add('text-blue-600', 'bg-blue-50', 'border-blue-600');
    }
</script>
@endsection
