@props(['title', 'description', 'icon'])

<div class="p-8 rounded-2xl bg-[var(--color-surface)] border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 animate-fade-up-scroll text-center flex flex-col items-center">
    <div class="w-20 h-20 rounded-2xl bg-[var(--color-primary)] text-[var(--color-accent)] flex items-center justify-center mb-6 shadow-md rotate-3 group-hover:rotate-0 transition-transform duration-300">
        <div class="-rotate-3 group-hover:rotate-0 transition-transform duration-300">
            {!! $icon !!}
        </div>
    </div>
    <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-3">{{ $title }}</h3>
    <p class="text-gray-500 text-sm leading-relaxed">{{ $description }}</p>
</div>
