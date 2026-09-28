@props(['title', 'count', 'icon'])

<a href="#" class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-[var(--color-accent)]/30 transition-all duration-300 flex flex-col items-center text-center animate-fade-up-scroll">
    <div class="w-16 h-16 rounded-full bg-[var(--color-surface-alt)] text-[var(--color-primary)] group-hover:bg-[var(--color-accent)] group-hover:text-white flex items-center justify-center transition-colors duration-300 mb-4">
        {!! $icon !!}
    </div>
    <h3 class="font-heading text-lg font-bold text-[var(--color-primary)] mb-1 group-hover:text-[var(--color-accent)] transition-colors">{{ $title }}</h3>
    <p class="text-sm text-gray-500">{{ $count }} Properties</p>
</a>
