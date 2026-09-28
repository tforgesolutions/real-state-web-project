@props(['name', 'city', 'image', 'propertiesCount'])

<a href="{{ route('locations.area', ['city' => Str::slug($city), 'area' => Str::slug($name)]) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 flex items-center p-4 animate-fade-up-scroll">
    <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 relative">
        <img src="{{ $image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
    </div>
    
    <div class="ml-4 flex-1">
        <h3 class="font-heading text-lg font-bold text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">{{ $name }}</h3>
        <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">{{ $city }}</p>
        <span class="text-sm font-medium text-gray-600 flex items-center">
            <svg class="w-4 h-4 mr-1 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            {{ $propertiesCount }} Properties
        </span>
    </div>
    
    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-[var(--color-primary)] group-hover:text-white transition-colors transform group-hover:translate-x-1">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </div>
</a>
