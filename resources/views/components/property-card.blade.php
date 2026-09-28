@props(['image', 'title', 'location', 'type', 'status', 'price', 'bedrooms', 'bathrooms', 'area', 'featured' => false, 'layout' => 'grid', 'link' => null])
@php
    $href = $link ?? route('properties.show', Str::slug($title));
@endphp

@if($layout === 'list')
<!-- List View Layout -->
<div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col sm:flex-row h-auto sm:h-64 animate-fade-up-scroll relative">
    
    <!-- Desktop absolute favorite button for list view -->
    <button type="button" class="favorite-btn hidden sm:block absolute top-4 right-4 p-2 bg-white/80 hover:bg-white text-gray-400 hover:text-red-500 rounded-full transition-colors backdrop-blur-sm focus:outline-none z-10 shadow-sm" aria-label="Save property" data-title="{{ $title }}" data-image="{{ $image }}" data-location="{{ $location }}" data-type="{{ $type }}" data-status="{{ $status }}" data-price="{{ $price }}" data-bedrooms="{{ $bedrooms }}" data-bathrooms="{{ $bathrooms }}" data-area="{{ $area }}">
        <svg class="w-5 h-5 transition-colors fill-none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
    </button>

    <div class="relative w-full sm:w-2/5 h-48 sm:h-full overflow-hidden">
        <a href="{{ $href }}">
            <img src="{{ $image }}" alt="{{ $title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
        </a>
        
        <div class="absolute top-4 left-4 flex flex-col gap-2 pointer-events-none">
            @if($featured)
                <span class="bg-[var(--color-accent)] text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                    Featured
                </span>
            @endif
            <span class="bg-[var(--color-primary)]/90 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm">
                {{ $status }}
            </span>
        </div>
        
        <!-- Actions -->
        <div class="absolute top-4 right-4 flex flex-col gap-2 z-10">
            <button type="button" class="favorite-btn p-2 bg-white/80 hover:bg-white text-gray-400 hover:text-red-500 rounded-full transition-colors backdrop-blur-sm focus:outline-none shadow-sm" aria-label="Save property" data-title="{{ $title }}" data-image="{{ $image }}" data-location="{{ $location }}" data-type="{{ $type }}" data-status="{{ $status }}" data-price="{{ $price }}" data-bedrooms="{{ $bedrooms }}" data-bathrooms="{{ $bathrooms }}" data-area="{{ $area }}">
                <svg class="w-5 h-5 transition-colors fill-none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </button>
            <button type="button" class="compare-btn p-2 bg-white/80 hover:bg-white text-gray-400 hover:text-[var(--color-primary)] rounded-full transition-colors backdrop-blur-sm focus:outline-none shadow-sm" aria-label="Compare property" data-title="{{ $title }}" data-image="{{ $image }}" data-location="{{ $location }}" data-type="{{ $type }}" data-status="{{ $status }}" data-price="{{ $price }}" data-bedrooms="{{ $bedrooms }}" data-bathrooms="{{ $bathrooms }}" data-area="{{ $area }}">
                <svg class="w-5 h-5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </button>
        </div>
    </div>

    <!-- Content Container -->
    <div class="p-6 flex flex-col flex-grow w-full sm:w-3/5">
        <div class="flex justify-between items-start mb-2 sm:pr-10">
            <div class="text-xs text-[var(--color-accent)] font-semibold uppercase tracking-wider">{{ $type }}</div>
            <span class="text-[var(--color-primary)] font-bold text-xl">{{ $price }}</span>
        </div>
        <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-2 group-hover:text-[var(--color-accent)] transition-colors line-clamp-1"><a href="{{ $href }}">{{ $title }}</a></h3>
        
        <div class="flex items-center text-gray-500 text-sm mb-4">
            <svg class="w-4 h-4 mr-1 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="truncate">{{ $location }}</span>
        </div>
        
        <p class="text-gray-500 text-sm line-clamp-2 mb-4 hidden md:block">Experience the epitome of luxury living in this exquisite property, designed with meticulous attention to detail and offering unparalleled comfort and style.</p>

        <div class="grid grid-cols-3 gap-4 pt-4 mt-auto border-t border-gray-100">
            <div class="flex items-center text-gray-600 text-sm">
                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>{{ $bedrooms }} Beds</span>
            </div>
            <div class="flex items-center text-gray-600 text-sm">
                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                <span>{{ $bathrooms }} Baths</span>
            </div>
            <div class="flex items-center text-gray-600 text-sm">
                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                <span>{{ $area }}</span>
            </div>
        </div>
    </div>
</div>
@else
<!-- Original Grid View Layout -->
<div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col h-full animate-fade-up-scroll">
    <!-- Image Container -->
    <div class="relative h-64 overflow-hidden">
        <a href="{{ $href }}">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
        </a>
        
        <div class="absolute top-4 left-4 flex flex-col gap-2 pointer-events-none">
            @if($featured)
                <span class="bg-[var(--color-accent)] text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                    Featured
                </span>
            @endif
            <span class="bg-[var(--color-primary)]/90 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm">
                {{ $status }}
            </span>
        </div>
        
        <div class="absolute top-4 right-4 flex flex-col gap-2 z-10">
            <button type="button" class="favorite-btn p-2 bg-white/80 hover:bg-white text-gray-400 hover:text-red-500 rounded-full transition-colors backdrop-blur-sm focus:outline-none shadow-sm" aria-label="Save property" data-title="{{ $title }}" data-image="{{ $image }}" data-location="{{ $location }}" data-type="{{ $type }}" data-status="{{ $status }}" data-price="{{ $price }}" data-bedrooms="{{ $bedrooms }}" data-bathrooms="{{ $bathrooms }}" data-area="{{ $area }}">
                <svg class="w-5 h-5 transition-colors fill-none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </button>
            <button type="button" class="compare-btn p-2 bg-white/80 hover:bg-white text-gray-400 hover:text-[var(--color-primary)] rounded-full transition-colors backdrop-blur-sm focus:outline-none shadow-sm" aria-label="Compare property" data-title="{{ $title }}" data-image="{{ $image }}" data-location="{{ $location }}" data-type="{{ $type }}" data-status="{{ $status }}" data-price="{{ $price }}" data-bedrooms="{{ $bedrooms }}" data-bathrooms="{{ $bathrooms }}" data-area="{{ $area }}">
                <svg class="w-5 h-5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </button>
        </div>
        
        <div class="absolute bottom-4 left-4">
            <span class="bg-white/95 text-[var(--color-primary)] font-bold px-4 py-1.5 rounded-lg shadow-lg backdrop-blur-sm">
                {{ $price }}
            </span>
        </div>
    </div>

    <!-- Content Container -->
    <div class="p-6 flex flex-col flex-grow">
        <div class="text-xs text-[var(--color-accent)] font-semibold uppercase tracking-wider mb-2">{{ $type }}</div>
        <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-2 group-hover:text-[var(--color-accent)] transition-colors line-clamp-1"><a href="{{ $href }}">{{ $title }}</a></h3>
        
        <div class="flex items-center text-gray-500 text-sm mb-4">
            <svg class="w-4 h-4 mr-1 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="truncate">{{ $location }}</span>
        </div>

        <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-4 mt-auto mb-6">
            <div class="flex items-center text-gray-600 text-sm">
                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>{{ $bedrooms }} Beds</span>
            </div>
            <div class="flex items-center text-gray-600 text-sm">
                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                <span>{{ $bathrooms }} Baths</span>
            </div>
            <div class="flex items-center text-gray-600 text-sm">
                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                <span>{{ $area }}</span>
            </div>
        </div>

        <a href="{{ $href }}" class="block w-full text-center py-3 border border-[var(--color-primary)] text-[var(--color-primary)] rounded-lg font-medium hover:bg-[var(--color-primary)] hover:text-white transition-colors duration-300">
            View Details
        </a>
    </div>
</div>
@endif

<script>
    // Component-level binding - binds event listener if not already bound
    if (!window.CardBtnsInitialized) {
        document.addEventListener('click', function(e) {
            // Favorite Button Logic
            const favBtn = e.target.closest('.favorite-btn');
            if(favBtn && window.AuraFavorites) {
                const data = favBtn.dataset;
                window.AuraFavorites.toggle({
                    title: data.title,
                    image: data.image,
                    location: data.location,
                    type: data.type,
                    status: data.status,
                    price: data.price,
                    bedrooms: data.bedrooms,
                    bathrooms: data.bathrooms,
                    area: data.area
                });
            }

            // Compare Button Logic
            const compBtn = e.target.closest('.compare-btn');
            if(compBtn && window.AuraCompare) {
                const data = compBtn.dataset;
                window.AuraCompare.toggle({
                    title: data.title,
                    image: data.image,
                    location: data.location,
                    type: data.type,
                    status: data.status,
                    price: data.price,
                    bedrooms: data.bedrooms,
                    bathrooms: data.bathrooms,
                    area: data.area
                });
            }
        });
        window.CardBtnsInitialized = true;
    }
</script>
