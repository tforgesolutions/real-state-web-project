@props(['image', 'logo', 'name', 'location', 'type', 'status', 'startingPrice', 'propertyTypes', 'description', 'featured' => false])

<div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col h-full animate-fade-up-scroll">
    <!-- Image Area -->
    <div class="relative h-60 overflow-hidden">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
        
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-10"></div>
        
        <!-- Status & Featured Badges -->
        <div class="absolute top-4 left-4 z-20 flex flex-col gap-2">
            @if($featured)
                <span class="bg-[var(--color-accent)] text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md inline-block w-max">
                    Featured
                </span>
            @endif
            <span class="bg-white/90 text-[var(--color-primary)] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm shadow-sm inline-block w-max">
                {{ $status }}
            </span>
        </div>
        
        <!-- Favorite Button -->
        <button class="absolute top-4 right-4 p-2 bg-white/80 hover:bg-white text-gray-400 hover:text-red-500 rounded-full transition-colors backdrop-blur-sm focus:outline-none z-20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
        </button>

        <!-- Project Logo & Price -->
        <div class="absolute bottom-4 left-4 right-4 z-20 flex justify-between items-end">
            @if($logo)
                <div class="w-12 h-12 rounded-lg bg-white p-1 shadow-md">
                    <img src="{{ $logo }}" class="w-full h-full object-contain" alt="{{ $name }} Logo">
                </div>
            @else
                <div class="w-12 h-12 rounded-lg bg-white/90 p-2 shadow-md flex items-center justify-center text-xs font-bold text-[var(--color-primary)]">
                    PROJ
                </div>
            @endif
            
            <div class="text-right">
                <span class="block text-xs text-white/90 font-medium drop-shadow-md">Starting from</span>
                <span class="text-lg font-bold text-white drop-shadow-md">{{ $startingPrice }}</span>
            </div>
        </div>
    </div>
    
    <!-- Content Area -->
    <div class="p-6 flex flex-col flex-grow">
        <div class="flex justify-between items-start mb-2">
            <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors line-clamp-1">{{ $name }}</h3>
        </div>
        
        <div class="flex items-center text-gray-500 text-sm mb-4">
            <svg class="w-4 h-4 mr-1 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="truncate">{{ $location }}</span>
        </div>
        
        <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $description }}</p>
        
        <!-- Property Types Badge List -->
        <div class="mt-auto pt-4 border-t border-gray-100">
            <div class="flex flex-wrap gap-2 mb-5">
                @foreach($propertyTypes as $ptype)
                    <span class="px-2 py-1 bg-gray-50 border border-gray-200 text-gray-600 text-xs rounded-md">{{ $ptype }}</span>
                @endforeach
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('projects.show', Str::slug($name)) }}" class="text-center py-2.5 bg-[var(--color-primary)] text-white rounded-lg text-sm font-medium hover:bg-[var(--color-primary-light)] transition-colors focus:outline-none">
                    View Project
                </a>
                <button class="text-center py-2.5 border border-[var(--color-primary)] text-[var(--color-primary)] rounded-lg text-sm font-medium hover:bg-[var(--color-primary)] hover:text-white transition-colors focus:outline-none">
                    Properties
                </button>
            </div>
        </div>
    </div>
</div>
