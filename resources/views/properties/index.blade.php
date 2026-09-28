@extends('layouts.app')

@section('title', 'Explore Properties | Aura Real Estate')

@php
    $layout = request('layout', 'grid');
    $purpose = request('purpose', 'buy');
    $sort = request('sort', 'newest');
    
    // Simulate Pagination
    $page = (int)request('page', 1);
    $totalItems = 24;
    $perPage = 9;
    $totalPages = ceil($totalItems / $perPage);
    
    // Determine active filters
    $activeFilters = [];
    if(request('purpose')) $activeFilters['purpose'] = ucfirst(request('purpose'));
    if(request('keyword')) $activeFilters['keyword'] = 'Keyword: ' . request('keyword');
    if(request('type')) $activeFilters['type'] = request('type');
    if(request('city')) $activeFilters['city'] = request('city');
    if(request('area')) $activeFilters['area'] = request('area');
    if(request('min_price') || request('max_price')) {
        $min = request('min_price') ? request('min_price') : '0';
        $max = request('max_price') ? request('max_price') : 'Any';
        $activeFilters['price'] = "Price: {$min} - {$max}";
    }
    if(request('beds')) $activeFilters['beds'] = request('beds') . ' Beds';
    if(request('baths')) $activeFilters['baths'] = request('baths') . ' Baths';
    if(request('furnished')) $activeFilters['furnished'] = request('furnished');
    if(request('property_id')) $activeFilters['property_id'] = 'ID: ' . request('property_id');
    
    // Amenities
    $selectedAmenities = request('amenities', []);
    foreach($selectedAmenities as $amenity) {
        $activeFilters["amenity_{$amenity}"] = $amenity;
    }
    
    // Simulate Empty State for testing
    $hasResults = request('keyword') === 'empty' ? false : true;
    
    if (!$hasResults) {
        $totalPages = 0;
        $totalItems = 0;
    }
@endphp

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- PAGE HEADER -->
    <div class="bg-[var(--color-primary)] text-white py-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-[var(--color-accent)]/10 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 animate-fade-up-scroll">
            <div class="flex items-center text-sm text-gray-400 mb-4 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-[var(--color-accent)] transition-colors">Home</a>
                <span>/</span>
                <span class="text-white">Properties</span>
            </div>
            <h1 class="font-heading text-4xl md:text-5xl font-bold mb-4">Explore Properties</h1>
            <p class="text-gray-300 max-w-2xl text-lg">Discover our curated collection of premium real estate. Use the filters to find a property that perfectly matches your lifestyle.</p>
        </div>
    </div>

    <!-- MAIN SEARCH BAR (COMPACT HEADER) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-2 md:p-4">
            <form id="compactSearchForm" action="{{ route('properties.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 md:gap-4 items-center">
                <!-- Keep hidden layout state -->
                <input type="hidden" name="layout" value="{{ $layout }}">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <input type="hidden" name="purpose" id="headerPurpose" value="{{ $purpose }}">
                
                <div class="flex w-full md:w-auto bg-gray-100 rounded-lg p-1">
                    <button type="button" onclick="setPurpose('buy')" class="flex-1 px-6 py-2.5 rounded-md text-sm font-bold transition-colors {{ $purpose === 'buy' ? 'bg-white shadow text-[var(--color-primary)]' : 'text-gray-500 hover:text-[var(--color-primary)]' }}">Buy</button>
                    <button type="button" onclick="setPurpose('rent')" class="flex-1 px-6 py-2.5 rounded-md text-sm font-bold transition-colors {{ $purpose === 'rent' ? 'bg-white shadow text-[var(--color-primary)]' : 'text-gray-500 hover:text-[var(--color-primary)]' }}">Rent</button>
                </div>
                
                <div class="w-full md:flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search by keyword, city, or area..." class="w-full pl-11 pr-4 py-3 bg-gray-50 border-0 rounded-lg focus:ring-2 focus:ring-[var(--color-accent)] text-gray-900 placeholder-gray-500 font-medium">
                </div>
                
                <div class="w-full md:w-48">
                    <select name="type" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-lg focus:ring-2 focus:ring-[var(--color-accent)] text-gray-900 font-medium appearance-none" onchange="document.getElementById('compactSearchForm').submit()">
                        <option value="">Property Type</option>
                        <option value="House" {{ request('type') == 'House' ? 'selected' : '' }}>House</option>
                        <option value="Apartment" {{ request('type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="Villa" {{ request('type') == 'Villa' ? 'selected' : '' }}>Villa</option>
                        <option value="Commercial" {{ request('type') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                    </select>
                </div>
                
                <div class="flex w-full md:w-auto gap-2">
                    <button type="button" onclick="toggleMobileFilter()" class="flex-1 md:hidden bg-gray-100 text-[var(--color-primary)] px-4 py-3 rounded-lg font-bold flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filters
                    </button>
                    <button type="submit" class="flex-1 md:w-auto btn-primary px-8 py-3 rounded-lg font-bold shadow-md hover:shadow-lg">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MAIN LAYOUT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- ADVANCED FILTER SIDEBAR / DRAWER -->
            <aside id="filterSidebar" class="fixed inset-0 z-[100] bg-black/50 lg:bg-transparent lg:static w-full lg:w-1/4 h-full lg:h-auto overflow-hidden lg:overflow-visible transition-opacity duration-300 opacity-0 pointer-events-none lg:opacity-100 lg:pointer-events-auto">
                
                <div id="filterDrawer" class="absolute top-0 right-0 w-4/5 max-w-sm h-full bg-white lg:w-full lg:max-w-none lg:h-auto lg:bg-transparent lg:static transform translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-y-auto lg:overflow-visible flex flex-col">
                    
                    <!-- Mobile Drawer Header -->
                    <div class="flex justify-between items-center lg:hidden p-6 border-b border-gray-100 bg-white sticky top-0 z-10">
                        <div class="flex items-center">
                            <h2 class="font-heading text-xl font-bold text-[var(--color-primary)]">Filters</h2>
                            @if(count($activeFilters) > 0)
                                <span class="ml-2 bg-[var(--color-accent)] text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ count($activeFilters) }}</span>
                            @endif
                        </div>
                        <button onclick="toggleMobileFilter()" class="text-gray-500 hover:text-[var(--color-accent)] focus:outline-none p-2 bg-gray-50 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="glass-panel rounded-none lg:rounded-2xl p-6 lg:p-8 flex-1 lg:sticky lg:top-28">
                        <form id="advancedFilterForm" action="{{ route('properties.index') }}" method="GET" class="space-y-6">
                            <!-- Hidden Sync Fields -->
                            <input type="hidden" name="layout" value="{{ $layout }}">
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <input type="hidden" name="purpose" value="{{ $purpose }}">
                            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                            <input type="hidden" name="type" value="{{ request('type') }}">

                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-bold text-gray-900">Advanced Filters</h3>
                                @if(count($activeFilters) > 0)
                                    <a href="{{ route('properties.index') }}" class="text-xs font-semibold text-[var(--color-accent)] hover:underline">Reset All</a>
                                @endif
                            </div>
                            
                            <!-- Location Specifics -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">City</label>
                                <select name="city" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    <option value="">Any City</option>
                                    <option value="Los Angeles" {{ request('city') == 'Los Angeles' ? 'selected' : '' }}>Los Angeles</option>
                                    <option value="New York" {{ request('city') == 'New York' ? 'selected' : '' }}>New York</option>
                                    <option value="Miami" {{ request('city') == 'Miami' ? 'selected' : '' }}>Miami</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Area / Locality</label>
                                <input type="text" name="area" value="{{ request('area') }}" placeholder="e.g. Beverly Hills" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                            </div>

                            <!-- Price Range -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Price Range ($)</label>
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-1/2 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    <span class="text-gray-400">-</span>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-1/2 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                </div>
                            </div>

                            <!-- Beds & Baths -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Bedrooms</label>
                                    <select name="beds" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                        <option value="">Any</option>
                                        <option value="1+" {{ request('beds') == '1+' ? 'selected' : '' }}>1+</option>
                                        <option value="2+" {{ request('beds') == '2+' ? 'selected' : '' }}>2+</option>
                                        <option value="3+" {{ request('beds') == '3+' ? 'selected' : '' }}>3+</option>
                                        <option value="4+" {{ request('beds') == '4+' ? 'selected' : '' }}>4+</option>
                                        <option value="5+" {{ request('beds') == '5+' ? 'selected' : '' }}>5+</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Bathrooms</label>
                                    <select name="baths" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                        <option value="">Any</option>
                                        <option value="1+" {{ request('baths') == '1+' ? 'selected' : '' }}>1+</option>
                                        <option value="2+" {{ request('baths') == '2+' ? 'selected' : '' }}>2+</option>
                                        <option value="3+" {{ request('baths') == '3+' ? 'selected' : '' }}>3+</option>
                                        <option value="4+" {{ request('baths') == '4+' ? 'selected' : '' }}>4+</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Area Size -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Area Size (Sq Ft)</label>
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="min_area" value="{{ request('min_area') }}" placeholder="Min" class="w-1/2 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    <span class="text-gray-400">-</span>
                                    <input type="number" name="max_area" value="{{ request('max_area') }}" placeholder="Max" class="w-1/2 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                </div>
                            </div>
                            
                            <!-- Furnished Status -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Furnishing</label>
                                <select name="furnished" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    <option value="">Any Status</option>
                                    <option value="Furnished" {{ request('furnished') == 'Furnished' ? 'selected' : '' }}>Furnished</option>
                                    <option value="Unfurnished" {{ request('furnished') == 'Unfurnished' ? 'selected' : '' }}>Unfurnished</option>
                                </select>
                            </div>

                            <!-- Amenities (Checkbox Group) -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Amenities</label>
                                <div class="grid grid-cols-2 gap-3 max-h-40 overflow-y-auto pr-2 custom-scrollbar">
                                    @foreach(['Parking', 'Balcony', 'Garden', 'Swimming Pool', 'Security', 'Elevator', 'Gym', 'Backup Power'] as $amenity)
                                        <label class="flex items-center space-x-2 cursor-pointer group">
                                            <input type="checkbox" name="amenities[]" value="{{ $amenity }}" {{ in_array($amenity, $selectedAmenities) ? 'checked' : '' }} class="w-4 h-4 text-[var(--color-accent)] border-gray-300 rounded focus:ring-[var(--color-accent)]">
                                            <span class="text-sm text-gray-600 group-hover:text-gray-900">{{ $amenity }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Property ID -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Property ID</label>
                                <input type="text" name="property_id" value="{{ request('property_id') }}" placeholder="e.g. AUR-8924" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                            </div>

                            <!-- Apply Button -->
                            <div class="pt-6 border-t border-gray-100 lg:sticky lg:bottom-0 bg-white lg:bg-transparent pb-4 lg:pb-0">
                                <button type="submit" class="w-full btn-primary py-3.5 rounded-xl shadow-lg font-bold text-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    Show Results
                                </button>
                            </div>
                        </form>
                        
                        <!-- Create Alert CTA -->
                        <div class="mt-8 bg-gradient-to-br from-[var(--color-primary)] to-gray-900 rounded-xl p-6 text-center text-white shadow-lg relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                            <div class="w-12 h-12 bg-white/10 backdrop-blur border border-white/20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-white relative z-10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            <h4 class="font-bold mb-1 relative z-10 text-lg">Save this search</h4>
                            <p class="text-sm text-gray-300 mb-5 relative z-10">Get notified when new properties match these filters.</p>
                            <a href="{{ route('account.alerts.create') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" class="block w-full py-3 bg-white text-[var(--color-primary)] rounded-lg font-bold hover:bg-gray-50 transition-colors relative z-10 shadow-md">
                                Create Alert
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- RESULTS AREA -->
            <main class="w-full lg:w-3/4 flex flex-col h-full min-h-[600px]">
                
                <!-- Results Header & Controls -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-1">Search Results</h2>
                        <p class="text-sm text-gray-500 font-medium">
                            @if(count($activeFilters) > 0)
                                Filtered Properties
                            @else
                                Featured Properties
                            @endif
                        </p>
                    </div>

                    <div class="flex items-center space-x-3 w-full sm:w-auto">
                        <!-- Sort Dropdown -->
                        <div class="relative w-full sm:w-auto">
                            <select onchange="updateSort(this.value)" class="w-full sm:w-48 appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 px-4 pr-8 rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] shadow-sm">
                                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="area_asc" {{ $sort === 'area_asc' ? 'selected' : '' }}>Area: Small to Large</option>
                                <option value="area_desc" {{ $sort === 'area_desc' ? 'selected' : '' }}>Area: Large to Small</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>

                        <!-- View Toggles (Desktop only) -->
                        <div class="hidden md:flex bg-white border border-gray-200 rounded-lg p-1 shadow-sm">
                            <button onclick="updateLayout('grid')" class="p-1.5 rounded focus:outline-none transition-colors {{ $layout === 'grid' ? 'bg-gray-100 text-[var(--color-primary)] shadow-sm' : 'text-gray-400 hover:text-[var(--color-primary)]' }}" title="Grid View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            </button>
                            <button onclick="updateLayout('list')" class="p-1.5 rounded focus:outline-none transition-colors {{ $layout === 'list' ? 'bg-gray-100 text-[var(--color-primary)] shadow-sm' : 'text-gray-400 hover:text-[var(--color-primary)]' }}" title="List View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            <button onclick="updateLayout('map')" class="p-1.5 rounded focus:outline-none transition-colors {{ $layout === 'map' ? 'bg-gray-100 text-[var(--color-primary)] shadow-sm' : 'text-gray-400 hover:text-[var(--color-primary)]' }}" title="Map View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Active Filters Tags -->
                @if(count($activeFilters) > 0)
                    <div class="flex flex-wrap gap-2 mb-6 items-center" id="activeFilterChips">
                        <span class="text-xs text-gray-500 font-semibold mr-1">Active Filters:</span>
                        
                        @foreach($activeFilters as $key => $label)
                            <x-filter-chip :name="$key" :value="$key" :label="$label" />
                        @endforeach
                        
                        <a href="{{ route('properties.index') }}" class="text-xs text-red-500 font-bold hover:underline ml-2">Clear All</a>
                    </div>
                @endif

                @if($hasResults)
                    
                    @if($layout === 'map')
                        <!-- MAP VIEW LAYOUT -->
                        <div class="flex flex-col xl:flex-row gap-6 h-[800px] mb-8">
                            <!-- Map Container -->
                            <div class="w-full xl:w-1/2 h-[400px] xl:h-full order-1 xl:order-2 rounded-2xl overflow-hidden shadow-lg sticky top-28 z-10 border border-gray-200">
                                <x-map-placeholder />
                            </div>
                            
                            <!-- Scrollable List -->
                            <div class="w-full xl:w-1/2 h-full overflow-y-auto pr-2 custom-scrollbar order-2 xl:order-1 space-y-6">
                                @forelse($realProperties as $property)
                                    @php
                                        $image = !empty($property->images) ? Storage::url($property->images[0]) : 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?q=80&w=1740&auto=format&fit=crop';
                                    @endphp
                                    <x-property-card 
                                        :image="$image" 
                                        :title="$property->title" 
                                        :location="$property->city . ', ' . $property->area_locality" 
                                        :type="$property->property_type" 
                                        :status="$property->purpose === 'buy' ? 'For Sale' : 'For Rent'" 
                                        :price="'$'.number_format($property->price)" 
                                        :bedrooms="$property->bedrooms" 
                                        :bathrooms="$property->bathrooms" 
                                        :area="$property->area . ' sqft'" 
                                        :featured="$property->is_featured" 
                                        :layout="'list'"
                                        :link="route('properties.show', $property->slug)"
                                    />
                                @empty
                                    <p class="text-gray-500">No properties available in map view.</p>
                                @endforelse
                            </div>
                        </div>
                    @else
                        <!-- GRID / LIST VIEW LAYOUT -->
                        <div id="propertiesContainer" class="grid {{ $layout === 'list' ? 'grid-cols-1' : 'grid-cols-1 md:grid-cols-2 xl:grid-cols-3' }} gap-6 transition-all duration-500 mb-10">
                            @forelse($realProperties as $property)
                                @php
                                    $image = !empty($property->images) ? Storage::url($property->images[0]) : 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?q=80&w=1740&auto=format&fit=crop';
                                @endphp
                                <x-property-card 
                                    :image="$image" 
                                    :title="$property->title" 
                                    :location="$property->city . ', ' . $property->area_locality" 
                                    :type="$property->property_type" 
                                    :status="$property->purpose === 'buy' ? 'For Sale' : 'For Rent'" 
                                    :price="'$'.number_format($property->price)" 
                                    :bedrooms="$property->bedrooms" 
                                    :bathrooms="$property->bathrooms" 
                                    :area="$property->area . ' sqft'" 
                                    :featured="$property->is_featured" 
                                    :layout="$layout"
                                    :link="route('properties.show', $property->slug)"
                                />
                            @empty
                                <div class="col-span-full py-12 text-center text-gray-500">
                                    <i class="fas fa-building text-4xl mb-3 text-gray-300"></i>
                                    <p>No properties match your criteria.</p>
                                </div>
                            @endforelse
                        </div>
                    @endif

                    <!-- PAGINATION -->
                    @if($totalPages > 1)
                        <div class="mt-auto pt-8 border-t border-gray-100 flex items-center justify-between">
                            <button onclick="changePage({{ max(1, $page - 1) }})" class="flex items-center px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-[var(--color-primary)] transition-colors {{ $page <= 1 ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                Previous
                            </button>
                            
                            <div class="hidden sm:flex space-x-2">
                                @for($i = 1; $i <= min(5, $totalPages); $i++)
                                    <button onclick="changePage({{ $i }})" class="w-10 h-10 flex items-center justify-center rounded-lg text-sm font-bold transition-colors {{ $page === $i ? 'bg-[var(--color-primary)] text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600 hover:border-[var(--color-primary)] hover:text-[var(--color-primary)]' }}">
                                        {{ $i }}
                                    </button>
                                @endfor
                                @if($totalPages > 5)
                                    <span class="w-10 h-10 flex items-center justify-center text-gray-500 font-bold">...</span>
                                @endif
                            </div>
                            
                            <span class="sm:hidden text-sm font-semibold text-gray-600">Page {{ $page }} of {{ $totalPages }}</span>
                            
                            <button onclick="changePage({{ min($totalPages, $page + 1) }})" class="flex items-center px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-[var(--color-primary)] transition-colors {{ $page >= $totalPages ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                                Next
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    @endif

                @else
                    <!-- EMPTY STATE -->
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm px-4">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6 shadow-inner text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="font-heading text-2xl font-bold text-gray-900 mb-2">No properties found</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-8">We couldn't find any properties matching your current search criteria. Try adjusting your filters or search area.</p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('properties.index') }}" class="btn-secondary px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition-colors">Clear All Filters</a>
                            <a href="{{ route('locations.index') }}" class="btn-primary px-6 py-2.5 rounded-xl font-bold shadow-md hover:shadow-lg transition-all">Explore Locations</a>
                        </div>
                    </div>
                @endif
                
            </main>
        </div>
    </div>
</div>

<script>
    // URL/Form State Management
    function setPurpose(purpose) {
        document.getElementById('headerPurpose').value = purpose;
        document.getElementById('compactSearchForm').submit();
    }

    function updateLayout(layout) {
        const url = new URL(window.location.href);
        url.searchParams.set('layout', layout);
        window.location.href = url.toString();
    }

    function updateSort(sort) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sort);
        window.location.href = url.toString();
    }

    function changePage(page) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        window.location.href = url.toString();
    }

    // Filter Chip Removal
    function removeFilter(filterName) {
        const form = document.getElementById('advancedFilterForm');
        
        if (filterName.startsWith('amenity_')) {
            const val = filterName.replace('amenity_', '');
            const checkboxes = form.querySelectorAll('input[name="amenities[]"]');
            checkboxes.forEach(cb => {
                if(cb.value === val) cb.checked = false;
            });
        } else {
            // Check if the input exists in the form
            const input = form.querySelector(`[name="${filterName}"]`);
            if (input) {
                if(input.tagName === 'SELECT') {
                    input.selectedIndex = 0;
                } else {
                    input.value = '';
                }
            } else {
                // If the filter is in the compact form
                const compactInput = document.getElementById('compactSearchForm').querySelector(`[name="${filterName}"]`);
                if(compactInput) {
                    compactInput.value = '';
                }
            }
        }
        
        form.submit();
    }

    // Mobile Filter Drawer Logic
    const filterSidebar = document.getElementById('filterSidebar');
    const filterDrawer = document.getElementById('filterDrawer');
    let filterOpen = false;
    
    function toggleMobileFilter() {
        filterOpen = !filterOpen;
        if (filterOpen) {
            // Open
            filterSidebar.classList.remove('opacity-0', 'pointer-events-none');
            filterDrawer.classList.remove('translate-x-full');
            document.body.style.overflow = 'hidden';
        } else {
            // Close
            filterDrawer.classList.add('translate-x-full');
            setTimeout(() => {
                filterSidebar.classList.add('opacity-0', 'pointer-events-none');
                document.body.style.overflow = '';
            }, 300);
        }
    }
    
    // Close on overlay click
    filterSidebar.addEventListener('click', function(e) {
        if (e.target === filterSidebar) {
            toggleMobileFilter();
        }
    });

    // Handle Resize (reset body overflow if resized to desktop)
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024 && filterOpen) { // lg breakpoint
            document.body.style.overflow = '';
        } else if (window.innerWidth < 1024 && filterOpen) {
            document.body.style.overflow = 'hidden';
        }
    });
</script>
@endsection
