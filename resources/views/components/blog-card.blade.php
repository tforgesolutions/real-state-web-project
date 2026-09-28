@props(['title', 'excerpt', 'category', 'image', 'date', 'readTime'])

<article class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col h-full animate-fade-up-scroll">
    <a href="{{ route('blog.show', Str::slug($title)) }}" class="relative h-56 overflow-hidden block">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-500"></div>
        <div class="absolute top-4 left-4">
            <span class="bg-white/90 backdrop-blur text-[var(--color-primary)] text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                {{ $category }}
            </span>
        </div>
    </a>
    
    <div class="p-6 md:p-8 flex flex-col flex-grow">
        <div class="flex items-center text-xs text-gray-500 font-medium tracking-wide uppercase mb-4 space-x-3">
            <span>{{ $date }}</span>
            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ $readTime }}
            </span>
        </div>
        
        <h3 class="font-heading text-xl md:text-2xl font-bold text-[var(--color-primary)] mb-3 group-hover:text-[var(--color-accent)] transition-colors line-clamp-2">
            <a href="{{ route('blog.show', Str::slug($title)) }}">
                {{ $title }}
            </a>
        </h3>
        
        <p class="text-gray-600 mb-6 line-clamp-3 text-sm md:text-base">
            {{ $excerpt }}
        </p>
        
        <div class="mt-auto pt-6 border-t border-gray-100 flex items-center justify-between">
            <a href="{{ route('blog.show', Str::slug($title)) }}" class="inline-flex items-center text-[var(--color-primary)] font-bold text-sm hover:text-[var(--color-accent)] transition-colors">
                Read Article
                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</article>
