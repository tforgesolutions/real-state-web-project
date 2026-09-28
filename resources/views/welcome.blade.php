@extends('layouts.app')

@section('title', 'Aura | Premium Real Estate')

@section('content')
<div class="relative min-h-screen flex items-center pt-20 overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ \App\Models\Setting::get('home_hero_bg') ? Storage::url(\App\Models\Setting::get('home_hero_bg')) : 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075&auto=format&fit=crop' }}" 
             alt="Premium Architecture" 
             class="w-full h-full object-cover object-center animate-image-reveal origin-center scale-105"
             loading="eager">
        <div class="absolute inset-0 bg-gradient-to-r from-[var(--color-primary)]/90 via-[var(--color-primary)]/70 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-[var(--color-surface)]"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            
            <!-- Hero Text Content -->
            <div class="lg:col-span-7 text-white animate-fade-up">
                @if(\App\Models\Setting::get('show_home_hero', '1') == '1')
                <span class="inline-block py-1 px-3 border border-white/30 rounded-full text-xs font-medium tracking-widest uppercase mb-6 backdrop-blur-sm">
                    Exceptional Living
                </span>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-heading font-bold leading-tight mb-6 text-white">
                    {!! \App\Models\Setting::get('home_hero_title', 'Discover Your <br><span class="text-[var(--color-accent)] italic font-light">Architectural</span> Masterpiece.') !!}
                </h1>
                <p class="text-lg md:text-xl text-gray-300 font-light max-w-2xl mb-10 leading-relaxed">
                    {{ \App\Models\Setting::get('home_hero_subtitle', 'Explore a curated collection of the world\'s most exquisite properties. Elevate your lifestyle with our premium real estate portfolio.') }}
                </p>
                <div class="flex flex-wrap gap-4 mb-16">
                    <a href="{{ \App\Models\Setting::get('home_hero_button_link', '#search') }}" class="btn-primary text-white border border-[var(--color-accent)] hover:shadow-lg hover:shadow-[var(--color-accent)]/20">
                        {{ \App\Models\Setting::get('home_hero_button_text', 'Explore Properties') }}
                    </a>
                    <a href="{{ route('properties.create') }}" class="btn-secondary text-white border-white/40 hover:bg-white hover:text-[var(--color-primary)]">
                        List Your Property
                    </a>
                </div>
                @endif
                
                <!-- Trust/Stats Area -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-8 border-t border-white/20">
                    <div>
                        <div class="text-3xl font-heading font-bold text-white mb-1">2.5k+</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">Premium Listings</div>
                    </div>
                    <div>
                        <div class="text-3xl font-heading font-bold text-white mb-1">45</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">Global Cities</div>
                    </div>
                    <div>
                        <div class="text-3xl font-heading font-bold text-white mb-1">100%</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">Verified</div>
                    </div>
                    <div>
                        <div class="text-3xl font-heading font-bold text-white mb-1">150+</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">Trusted Agents</div>
                    </div>
                </div>
            </div>

            <!-- Search Panel -->
            @if(\App\Models\Setting::get('show_home_search', '1') == '1')
            <div class="lg:col-span-5 w-full mt-12 lg:mt-0 animate-fade-up-delayed" id="search">
                <div class="glass-panel rounded-2xl overflow-hidden shadow-2xl bg-white/95 text-[var(--color-primary)] relative z-30" id="heroSearchPanel">
                    
                    <!-- Search Tabs -->
                    <div class="flex border-b border-gray-200" id="heroSearchTabs">
                        <button type="button" data-tab="buy" class="flex-1 py-4 text-sm font-semibold border-b-2 border-[var(--color-accent)] text-[var(--color-accent)] transition-colors">
                            Buy
                        </button>
                        <button type="button" data-tab="rent" class="flex-1 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-[var(--color-primary)] transition-colors">
                            Rent
                        </button>
                        <button type="button" data-tab="projects" class="flex-1 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-[var(--color-primary)] transition-colors">
                            Projects
                        </button>
                    </div>

                    <!-- Search Form -->
                    <form id="heroSearchForm" class="p-6 md:p-8 space-y-5" action="{{ route('properties.index') }}" method="GET">
                        <input type="hidden" name="purpose" id="searchPurpose" value="buy">
                        <input type="hidden" name="beds" id="searchBeds" value="">

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2" for="searchKeyword">Location</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </span>
                                <input type="text" id="searchKeyword" name="keyword" placeholder="City, Area, or Zip Code" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:border-transparent transition-all relative z-10 cursor-text">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2" for="searchType">Property Type</label>
                                <select name="type" id="searchType" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all cursor-pointer">
                                    <option value="">Any Type</option>
                                    @php
                                        $propTypes = \App\Models\PropertyType::where('status', 'Active')->get();
                                    @endphp
                                    @foreach($propTypes as $pType)
                                        <option value="{{ $pType->name }}">{{ $pType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2" for="searchPrice">Price Range</label>
                                <select name="price_range" id="searchPrice" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all cursor-pointer">
                                    <option value="">Any Price</option>
                                    <option value="0-500000">Under $500k</option>
                                    <option value="500000-1000000">$500k - $1M</option>
                                    <option value="1000000-2000000">$1M - $2M</option>
                                    <option value="2000000-5000000">$2M - $5M</option>
                                    <option value="5000000+">$5M+</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Bedrooms</label>
                            <div class="flex space-x-2" id="heroBedsContainer">
                                <button type="button" data-val="" class="flex-1 py-2 border border-[var(--color-accent)] text-[var(--color-accent)] rounded-lg hover:border-[var(--color-accent)] hover:text-[var(--color-accent)] transition-colors focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">Any</button>
                                <button type="button" data-val="1" class="flex-1 py-2 border border-gray-200 text-gray-700 rounded-lg hover:border-[var(--color-accent)] hover:text-[var(--color-accent)] transition-colors focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">1+</button>
                                <button type="button" data-val="2" class="flex-1 py-2 border border-gray-200 text-gray-700 rounded-lg hover:border-[var(--color-accent)] hover:text-[var(--color-accent)] transition-colors focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">2+</button>
                                <button type="button" data-val="3" class="flex-1 py-2 border border-gray-200 text-gray-700 rounded-lg hover:border-[var(--color-accent)] hover:text-[var(--color-accent)] transition-colors focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">3+</button>
                                <button type="button" data-val="4" class="flex-1 py-2 border border-gray-200 text-gray-700 rounded-lg hover:border-[var(--color-accent)] hover:text-[var(--color-accent)] transition-colors focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">4+</button>
                            </div>
                        </div>

                        <button type="submit" class="w-full btn-primary py-4 rounded-lg mt-4 text-lg shadow-lg relative z-20">
                            Search Properties
                        </button>
                    </form>
                </div>
            </div>
            @endif


        </div>
</div>
    </div>
</div>

<!-- PROPERTY CATEGORIES SECTION -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal-on-scroll">
            <span class="text-[var(--color-accent)] font-semibold tracking-widest uppercase text-sm">Browse by Type</span>
            <h2 class="font-heading text-4xl md:text-5xl font-bold text-[var(--color-primary)] mt-3">Property Categories</h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @php
                $propertyTypes = \App\Models\PropertyType::where('status', 'Active')->withCount('properties')->get();
            @endphp
            @foreach($propertyTypes as $type)
            <a href="{{ route('properties.index', ['type' => $type->name]) }}" class="block">
                <x-category-card 
                    title="{{ $type->name }}" 
                    count="{{ number_format($type->properties_count) }}" 
                    icon="{!! $type->icon ?? '<svg class=\'w-8 h-8\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6\'></path></svg>' !!}" 
                />
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- FEATURED PROPERTIES SECTION -->
@if(\App\Models\Setting::get('show_featured_properties', '1') == '1')
<section class="py-20 bg-[var(--color-surface-alt)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 reveal-on-scroll">
            <div>
                <span class="text-[var(--color-accent)] font-semibold tracking-widest uppercase text-sm">Exclusive Collection</span>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-[var(--color-primary)] mt-3">
                    {{ \App\Models\Setting::get('home_featured_heading', 'Featured Properties') }}
                </h2>
            </div>
            <a href="{{ route('properties.index') }}" class="mt-6 md:mt-0 text-[var(--color-primary)] font-semibold hover:text-[var(--color-accent)] transition-colors flex items-center">
                View All Featured <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredProperties as $property)
            <x-property-card 
                image="{{ $property->images ? Storage::url($property->images[0]) : 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1740&auto=format&fit=crop' }}"
                title="{{ $property->title }}"
                location="{{ $property->city }}"
                type="{{ $property->property_type }}"
                status="{{ ucfirst($property->status) }}"
                price="{{ $property->currency }} {{ number_format($property->price) }}"
                bedrooms="{{ $property->bedrooms }}"
                bathrooms="{{ $property->bathrooms }}"
                area="{{ $property->area }} sqft"
                :featured="$property->is_featured"
            />
            @empty
                <div class="col-span-full text-center py-8 text-gray-500">No featured properties available at the moment.</div>
            @endforelse
        </div>
    </div>
</section>
@endif

<!-- LATEST PROPERTIES SECTION -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 reveal-on-scroll">
            <div>
                <span class="text-[var(--color-accent)] font-semibold tracking-widest uppercase text-sm">New on Market</span>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-[var(--color-primary)] mt-3">Latest Properties</h2>
            </div>
            <a href="{{ route('properties.index') }}" class="mt-6 md:mt-0 btn-secondary px-6 py-2 rounded-lg">
                View All Properties
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $latestProps = \App\Models\Property::where('status', 'approved')->latest()->take(4)->get();
            @endphp
            @forelse($latestProps as $prop)
                <x-property-card 
                    image="{{ $prop->images ? Storage::url($prop->images[0]) : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1740&auto=format&fit=crop' }}"
                    title="{{ $prop->title }}"
                    location="{{ $prop->city }}"
                    type="{{ $prop->property_type }}"
                    status="{{ ucfirst($prop->status) }}"
                    price="{{ $prop->currency }} {{ number_format($prop->price) }}"
                    bedrooms="{{ $prop->bedrooms }}"
                    bathrooms="{{ $prop->bathrooms }}"
                    area="{{ $prop->area }} sqft"
                    :featured="$prop->is_featured"
                    :link="route('properties.show', $prop->slug)"
                />
            @empty
                <div class="col-span-full py-8 text-center text-gray-500">No properties available yet.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- EXPLORE BY LOCATION -->
<section class="py-20 bg-[var(--color-surface-alt)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal-on-scroll">
            <span class="text-[var(--color-accent)] font-semibold tracking-widest uppercase text-sm">Destinations</span>
            <h2 class="font-heading text-4xl md:text-5xl font-bold text-[var(--color-primary)] mt-3">Explore by Location</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $topLocations = \App\Models\Location::where('status', 'Active')->withCount('properties')->orderBy('properties_count', 'desc')->take(6)->get();
            @endphp
            @foreach($topLocations as $loc)
            <a href="{{ route('properties.index', ['city' => $loc->name]) }}" class="block">
                <x-location-card 
                    image="{{ $loc->image_url ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1738&auto=format&fit=crop' }}" 
                    title="{{ $loc->name }}" 
                    count="{{ number_format($loc->properties_count) }}" 
                />
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="py-24 bg-[var(--color-primary)] text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-[var(--color-accent)]/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-[var(--color-accent)]/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 reveal-on-scroll">
            <span class="text-[var(--color-accent)] font-semibold tracking-widest uppercase text-sm">Our Guarantee</span>
            <h2 class="font-heading text-4xl md:text-5xl font-bold mt-3 text-white">Why Choose Aura</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center reveal-on-scroll group">
                <div class="w-16 h-16 mx-auto bg-white/10 rounded-2xl flex items-center justify-center mb-6 text-[var(--color-accent)] group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-heading text-xl font-bold mb-3 text-white">Verified Listings</h3>
                <p class="text-gray-400 text-sm">Every property undergoes a rigorous verification process to ensure authenticity.</p>
            </div>
            <div class="text-center reveal-on-scroll group" style="transition-delay: 100ms">
                <div class="w-16 h-16 mx-auto bg-white/10 rounded-2xl flex items-center justify-center mb-6 text-[var(--color-accent)] group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="font-heading text-xl font-bold mb-3 text-white">Easy Property Search</h3>
                <p class="text-gray-400 text-sm">Advanced filters and intuitive design make finding your dream home effortless.</p>
            </div>
            <div class="text-center reveal-on-scroll group" style="transition-delay: 200ms">
                <div class="w-16 h-16 mx-auto bg-white/10 rounded-2xl flex items-center justify-center mb-6 text-[var(--color-accent)] group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="font-heading text-xl font-bold mb-3 text-white">Trusted Agents</h3>
                <p class="text-gray-400 text-sm">Work with top-tier real estate professionals dedicated to your success.</p>
            </div>
            <div class="text-center reveal-on-scroll group" style="transition-delay: 300ms">
                <div class="w-16 h-16 mx-auto bg-white/10 rounded-2xl flex items-center justify-center mb-6 text-[var(--color-accent)] group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="font-heading text-xl font-bold mb-3 text-white">Better Discovery</h3>
                <p class="text-gray-400 text-sm">Discover unique properties and new developments before they hit the market.</p>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS SECTION -->
@php
    $testimonials = \App\Models\Testimonial::where('status', true)
        ->where('featured', true)
        ->orderBy('display_order', 'asc')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();
@endphp
@if($testimonials->count() > 0)
<section class="py-20 bg-[var(--color-surface-alt)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal-on-scroll">
            <span class="text-[var(--color-accent)] font-semibold tracking-widest uppercase text-sm">Client Stories</span>
            <h2 class="font-heading text-4xl md:text-5xl font-bold text-[var(--color-primary)] mt-3">What Our Clients Say</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 reveal-on-scroll group hover:-translate-y-2 transition-transform duration-300">
                <div class="flex text-yellow-400 text-sm mb-6">
                    @for($i=0; $i<$testimonial->rating; $i++) <i class="fas fa-star"></i> @endfor
                    @for($i=$testimonial->rating; $i<5; $i++) <i class="far fa-star text-gray-300"></i> @endfor
                </div>
                <p class="text-gray-600 mb-8 italic">"{{ $testimonial->testimonial }}"</p>
                <div class="flex items-center mt-auto border-t border-gray-50 pt-6">
                    <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->client_name }}" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <h4 class="font-bold text-[var(--color-primary)]">{{ $testimonial->client_name }}</h4>
                        @if($testimonial->designation || $testimonial->company)
                        <p class="text-xs text-gray-500">
                            {{ $testimonial->designation }} 
                            @if($testimonial->designation && $testimonial->company) - @endif
                            {{ $testimonial->company }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA SECTION -->
@if(\App\Models\Setting::get('show_home_cta', '1') == '1')
<section class="py-24 bg-white relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="font-heading text-4xl md:text-5xl font-bold text-[var(--color-primary)] mb-6 reveal-on-scroll">
            {{ \App\Models\Setting::get('home_cta_heading', 'Ready to Find Your Dream Home?') }}
        </h2>
        <p class="text-lg text-gray-600 mb-10 max-w-2xl mx-auto reveal-on-scroll" style="transition-delay: 100ms">
            {{ \App\Models\Setting::get('home_cta_subtitle', 'Join thousands of satisfied clients who have found their perfect property through Aura. Whether you\'re buying, selling, or renting, we\'re here to help.') }}
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 reveal-on-scroll" style="transition-delay: 200ms">
            <a href="{{ \App\Models\Setting::get('home_cta_button_link', route('properties.index')) }}" class="btn-primary text-lg px-8 py-4 rounded-lg shadow-lg">
                {{ \App\Models\Setting::get('home_cta_button_text', 'Start Exploring') }}
            </a>
            <a href="{{ route('properties.create') }}" class="btn-secondary text-lg px-8 py-4 rounded-lg">List Your Property</a>
        </div>
    </div>
</section>
@endif

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
    });
</script>

<style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes imageReveal {
        from { transform: scale(1.1); }
        to { transform: scale(1.05); }
    }

    .animate-fade-up {
        animation: fadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    .animate-fade-up-delayed {
        opacity: 0;
        animation: fadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards;
    }

    .animate-image-reveal {
        animation: imageReveal 10s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }
    
    @media (prefers-reduced-motion: reduce) {
        .animate-fade-up, .animate-fade-up-delayed, .animate-image-reveal, .reveal-on-scroll {
            animation: none;
            opacity: 1;
            transform: none;
            transition: none;
        }
    }
    
    .reveal-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }
    
    .reveal-on-scroll.is-revealed {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Hero Search Form Logic
        const tabs = document.querySelectorAll('#heroSearchTabs button');
        const form = document.getElementById('heroSearchForm');
        const purposeInput = document.getElementById('searchPurpose');
        const bedsInput = document.getElementById('searchBeds');
        const bedBtns = document.querySelectorAll('#heroBedsContainer button');

        // Initial setup for form action based on projects route (if they exist)
        const basePropertiesRoute = "{{ route('properties.index') }}";
        const baseProjectsRoute = "{{ route('projects.index') }}";

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active classes from all
                tabs.forEach(t => {
                    t.classList.remove('border-[var(--color-accent)]', 'text-[var(--color-accent)]');
                    t.classList.add('border-transparent', 'text-gray-500');
                });

                // Add active classes to clicked tab
                tab.classList.add('border-[var(--color-accent)]', 'text-[var(--color-accent)]');
                tab.classList.remove('border-transparent', 'text-gray-500');

                // Update form state
                const selectedMode = tab.getAttribute('data-tab');
                
                if (selectedMode === 'projects') {
                    form.action = baseProjectsRoute;
                    purposeInput.disabled = true; // Projects don't need buy/rent purpose
                } else {
                    form.action = basePropertiesRoute;
                    purposeInput.disabled = false;
                    purposeInput.value = selectedMode;
                }
            });
        });

        bedBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active state
                bedBtns.forEach(b => {
                    b.classList.remove('border-[var(--color-accent)]', 'text-[var(--color-accent)]');
                    b.classList.add('border-gray-200', 'text-gray-700');
                });
                
                // Set active state on clicked
                btn.classList.add('border-[var(--color-accent)]', 'text-[var(--color-accent)]');
                btn.classList.remove('border-gray-200', 'text-gray-700');

                // Update hidden input
                bedsInput.value = btn.getAttribute('data-val');
            });
        });
    });
</script>
@endsection






