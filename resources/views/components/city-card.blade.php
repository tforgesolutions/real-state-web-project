@props(['image', 'name', 'propertiesCount', 'projectsCount'])

<a href="{{ route('locations.city', Str::slug($name)) }}" class="group relative bg-gray-900 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 h-80 block animate-fade-up-scroll">
    <img src="{{ $image }}" alt="{{ $name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out opacity-80 group-hover:opacity-100">
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
    
    <div class="absolute bottom-0 left-0 right-0 p-6">
        <h3 class="font-heading text-3xl font-bold text-white mb-2 group-hover:text-[var(--color-accent)] transition-colors drop-shadow-md">{{ $name }}</h3>
        <div class="flex gap-4 text-sm font-medium text-gray-200">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                {{ $propertiesCount }} Properties
            </span>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                {{ $projectsCount }} Projects
            </span>
        </div>
        
        <div class="mt-4 pt-4 border-t border-white/20 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
            <span class="text-white text-sm font-bold flex items-center">
                Explore City 
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </span>
        </div>
    </div>
</a>
