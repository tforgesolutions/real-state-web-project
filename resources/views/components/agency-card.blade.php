@props(['logo', 'name', 'description', 'location', 'specialization', 'agentCount', 'propertiesCount'])

<div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col h-full animate-fade-up-scroll">
    <div class="p-6 pb-0">
        <div class="flex justify-between items-start mb-4">
            <div class="w-20 h-20 rounded-xl overflow-hidden bg-white border border-gray-100 shadow-sm flex items-center justify-center p-2 group-hover:border-[var(--color-accent)] transition-colors">
                <img src="{{ $logo }}" alt="{{ $name }}" class="max-w-full max-h-full object-contain">
            </div>
            <span class="bg-[var(--color-surface-alt)] text-[var(--color-primary)] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                {{ $specialization }}
            </span>
        </div>
        
        <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-2 group-hover:text-[var(--color-accent)] transition-colors">{{ $name }}</h3>
        
        <div class="flex items-center text-gray-500 text-sm mb-4">
            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="truncate">{{ $location }}</span>
        </div>
        
        <p class="text-sm text-gray-600 line-clamp-2 mb-6 h-10">{{ $description }}</p>
    </div>
    
    <div class="p-6 pt-0 mt-auto">
        <div class="grid grid-cols-2 gap-4 py-4 border-t border-b border-gray-100 mb-5 text-center">
            <div>
                <span class="block text-xl font-bold text-[var(--color-primary)]">{{ $agentCount }}</span>
                <span class="text-xs text-gray-500 uppercase font-semibold">Agents</span>
            </div>
            <div>
                <span class="block text-xl font-bold text-[var(--color-primary)]">{{ $propertiesCount }}</span>
                <span class="text-xs text-gray-500 uppercase font-semibold">Properties</span>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('agencies.show', Str::slug($name)) }}" class="text-center py-2.5 bg-gray-50 text-[var(--color-primary)] rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors focus:outline-none">
                View Agency
            </a>
            <button class="text-center py-2.5 bg-transparent border border-[var(--color-primary)] text-[var(--color-primary)] rounded-lg text-sm font-medium hover:bg-[var(--color-primary)] hover:text-white transition-colors focus:outline-none">
                Contact
            </button>
        </div>
    </div>
</div>
