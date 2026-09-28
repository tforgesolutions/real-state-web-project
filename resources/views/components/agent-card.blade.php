@props(['id', 'image', 'name', 'title', 'agency', 'location', 'specialization', 'propertiesCount', 'rating', 'reviews'])

<div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col h-full animate-fade-up-scroll">
    <div class="relative h-48 overflow-hidden bg-[var(--color-surface-alt)]">
        <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/80 to-transparent z-10"></div>
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700 ease-in-out">
        
        <!-- Badges -->
        <div class="absolute top-4 left-4 z-20">
            <span class="bg-white/90 text-[var(--color-primary)] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm shadow-sm">
                {{ $specialization }}
            </span>
        </div>
        
        <!-- Info Over Image -->
        <div class="absolute bottom-4 left-4 right-4 z-20 text-white">
            <h3 class="font-heading text-xl font-bold mb-1">{{ $name }}</h3>
            <p class="text-xs text-gray-200 font-medium opacity-90">{{ $title }} at {{ $agency }}</p>
        </div>
    </div>
    
    <div class="p-5 flex flex-col flex-grow">
        <!-- Stats Row -->
        <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-100">
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 text-[var(--color-accent)] mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                <span class="font-bold text-gray-700">{{ $rating }}</span>
                <span class="ml-1">({{ $reviews }} Reviews)</span>
            </div>
            <div class="text-sm font-semibold text-[var(--color-primary)]">
                {{ $propertiesCount }} Listings
            </div>
        </div>
        
        <!-- Location -->
        <div class="flex items-center text-gray-500 text-sm mb-6 mt-auto">
            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="truncate">{{ $location }}</span>
        </div>
        
        <!-- Actions -->
        <div class="grid grid-cols-2 gap-3 mt-auto">
            <a href="{{ route('agents.show', $id ?? 1) }}" class="text-center py-2.5 border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:border-[var(--color-primary)] hover:text-[var(--color-primary)] transition-colors focus:outline-none">
                View Profile
            </a>
            <button class="text-center py-2.5 bg-[var(--color-primary)] text-white rounded-lg text-sm font-medium hover:bg-[var(--color-primary-light)] transition-colors focus:outline-none">
                Contact
            </button>
        </div>
    </div>
</div>
