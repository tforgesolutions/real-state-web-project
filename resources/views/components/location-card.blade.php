@props(['image', 'title', 'count' => '0'])

<a href="#" class="group relative rounded-2xl overflow-hidden h-72 w-full block shadow-sm hover:shadow-xl transition-all duration-500 animate-fade-up-scroll">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent group-hover:from-black/90 transition-all duration-500"></div>
    
    <div class="absolute bottom-0 left-0 w-full p-6 flex justify-between items-end">
        <div>
            <h3 class="font-heading text-2xl font-bold text-white mb-1">{{ $title }}</h3>
            <p class="text-gray-300 text-sm font-medium">{{ $count }} Properties</p>
        </div>
        <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-[var(--color-accent)] transition-colors duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </div>
    </div>
</a>
