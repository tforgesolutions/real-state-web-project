@extends('admin.layouts.app')

@section('title', 'Homepage CMS')
@section('header', 'Homepage Management')

@section('content')

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded shadow-sm">
    <div class="flex items-center">
        <i class="fas fa-check-circle text-green-500 mr-3"></i>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

<form action="{{ route('admin.homepage.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="space-y-8">
        
        <!-- Hero Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-800">Hero Section</h3>
                <label class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="show_home_hero" class="sr-only" value="1" {{ \App\Models\Setting::get('show_home_hero', '1') == '1' ? 'checked' : '' }}>
                        <div class="block bg-gray-200 w-10 h-6 rounded-full transition toggle-bg"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition toggle-dot"></div>
                    </div>
                    <div class="ml-3 text-sm font-medium text-gray-700">Show Section</div>
                </label>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Main Heading (HTML allowed)</label>
                    <textarea name="home_hero_title" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('home_hero_title', \App\Models\Setting::get('home_hero_title', 'Discover Your <br><span class="text-[var(--color-accent)] italic font-light">Architectural</span> Masterpiece.')) }}</textarea>
                </div>
                
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                    <textarea name="home_hero_subtitle" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('home_hero_subtitle', \App\Models\Setting::get('home_hero_subtitle', "Explore a curated collection of the world's most exquisite properties. Elevate your lifestyle with our premium real estate portfolio.")) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                    <input type="text" name="home_hero_button_text" value="{{ old('home_hero_button_text', \App\Models\Setting::get('home_hero_button_text', 'Explore Properties')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Button Link</label>
                    <input type="text" name="home_hero_button_link" value="{{ old('home_hero_button_link', \App\Models\Setting::get('home_hero_button_link', '#search')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>

                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Background Image</label>
                    @if(\App\Models\Setting::get('home_hero_bg'))
                        <div class="mb-3">
                            <img src="{{ Storage::url(\App\Models\Setting::get('home_hero_bg')) }}" alt="Hero Background" class="h-32 rounded object-cover shadow-sm">
                        </div>
                    @endif
                    <input type="file" name="home_hero_bg" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-200 rounded-md">
                    <p class="mt-1 text-xs text-gray-500">JPG, PNG or WEBP. Max 4MB. Recommended: 1920x1080px.</p>
                </div>
            </div>
        </div>

        <!-- Visibility / Other Sections -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-800">Dynamic Sections Visibility</h3>
                <p class="text-sm text-gray-500">Toggle or customize sections on the homepage.</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Search Box -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                    <div>
                        <h4 class="font-medium text-gray-800">Quick Search Box</h4>
                        <p class="text-sm text-gray-500">The property search block directly under the hero section.</p>
                    </div>
                    <label class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="show_home_search" class="sr-only" value="1" {{ \App\Models\Setting::get('show_home_search', '1') == '1' ? 'checked' : '' }}>
                            <div class="block bg-gray-200 w-10 h-6 rounded-full transition toggle-bg"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition toggle-dot"></div>
                        </div>
                    </label>
                </div>

                <!-- Featured Properties -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-50 gap-4">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">Featured Properties</h4>
                        <p class="text-sm text-gray-500 mb-2">Displays up to 6 properties marked as 'Featured'.</p>
                        <input type="text" name="home_featured_heading" value="{{ old('home_featured_heading', \App\Models\Setting::get('home_featured_heading', 'Featured Properties')) }}" placeholder="Heading" class="w-full sm:max-w-xs rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2 text-sm">
                    </div>
                    <label class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="show_featured_properties" class="sr-only" value="1" {{ \App\Models\Setting::get('show_featured_properties', '1') == '1' ? 'checked' : '' }}>
                            <div class="block bg-gray-200 w-10 h-6 rounded-full transition toggle-bg"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition toggle-dot"></div>
                        </div>
                    </label>
                </div>

                <!-- Featured Projects (Available for future usage if added to welcome view) -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-50 gap-4 opacity-50">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">Featured Projects (Add-on)</h4>
                        <p class="text-sm text-gray-500 mb-2">Toggle featured projects display.</p>
                        <input type="text" name="home_projects_heading" value="{{ old('home_projects_heading', \App\Models\Setting::get('home_projects_heading', 'New Developments')) }}" placeholder="Heading" class="w-full sm:max-w-xs rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2 text-sm">
                    </div>
                    <label class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="show_featured_projects" class="sr-only" value="1" {{ \App\Models\Setting::get('show_featured_projects', '0') == '1' ? 'checked' : '' }}>
                            <div class="block bg-gray-200 w-10 h-6 rounded-full transition toggle-bg"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition toggle-dot"></div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-800">Call To Action (Footer Block)</h3>
                <label class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="show_home_cta" class="sr-only" value="1" {{ \App\Models\Setting::get('show_home_cta', '1') == '1' ? 'checked' : '' }}>
                        <div class="block bg-gray-200 w-10 h-6 rounded-full transition toggle-bg"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition toggle-dot"></div>
                    </div>
                    <div class="ml-3 text-sm font-medium text-gray-700">Show CTA</div>
                </label>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                    <input type="text" name="home_cta_heading" value="{{ old('home_cta_heading', \App\Models\Setting::get('home_cta_heading', 'Ready to Find Your Dream Home?')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
                
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                    <textarea name="home_cta_subtitle" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('home_cta_subtitle', \App\Models\Setting::get('home_cta_subtitle', 'Join thousands of satisfied clients who have found their perfect property through Aura.')) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                    <input type="text" name="home_cta_button_text" value="{{ old('home_cta_button_text', \App\Models\Setting::get('home_cta_button_text', 'Start Exploring')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Button Link</label>
                    <input type="text" name="home_cta_button_link" value="{{ old('home_cta_button_link', \App\Models\Setting::get('home_cta_button_link', '/properties')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>
            </div>
        </div>

        <div class="flex justify-end pb-12">
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-sm font-bold shadow hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 flex items-center">
                <i class="fas fa-save mr-2"></i> Save Homepage Configuration
            </button>
        </div>
    </div>
</form>

<style>
input:checked ~ .toggle-bg {
    background-color: #2563eb;
}
input:checked ~ .toggle-dot {
    transform: translateX(100%);
}
</style>
@endsection
