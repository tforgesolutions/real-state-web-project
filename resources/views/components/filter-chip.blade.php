@props(['name', 'value', 'label'])

<div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-[var(--color-surface-alt)] text-[var(--color-primary)] border border-gray-200 shadow-sm animate-fade-up-scroll filter-chip" data-param="{{ $name }}" data-value="{{ $value }}">
    {{ $label }}
    <button type="button" onclick="removeFilter('{{ $name }}')" class="ml-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full p-0.5 transition-colors focus:outline-none" aria-label="Remove {{ $label }} filter">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
