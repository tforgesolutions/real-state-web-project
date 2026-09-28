@extends('layouts.app')

@section('title', 'Property Comparison | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('account.index') }}" class="hover:text-[var(--color-primary)] transition-colors">My Account</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">Compare Properties</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden min-h-[600px]">
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] flex items-center">
                            Comparison List <span id="compPageCount" class="ml-3 bg-[var(--color-accent)]/10 text-[var(--color-accent)] text-sm px-3 py-1 rounded-full font-bold">0</span>
                        </h2>
                        <a href="{{ route('compare.index') }}" class="text-sm font-bold text-[var(--color-accent)] hover:underline">View Full Screen Table &rarr;</a>
                    </div>
                    
                    <div class="p-8">
                        <div id="compareGrid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Populated by JS -->
                        </div>

                        <!-- Empty State -->
                        <div id="compareEmptyState" class="hidden text-center py-20">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-3">No properties to compare</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">Add properties to your comparison list to evaluate them side-by-side.</p>
                            <a href="{{ route('properties.index') }}" class="btn-primary py-3 px-8 rounded-xl font-bold shadow-md inline-block">Explore Properties</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const grid = document.getElementById('compareGrid');
        const emptyState = document.getElementById('compareEmptyState');
        const compCount = document.getElementById('compPageCount');

        function renderCompare() {
            if(!window.AuraCompare) return;
            
            const list = window.AuraCompare.get();
            compCount.innerText = list.length;

            if (list.length === 0) {
                grid.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
                grid.classList.remove('hidden');
                
                grid.innerHTML = '';
                
                list.forEach(prop => {
                    const card = document.createElement('div');
                    card.className = 'bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 flex flex-col relative group';
                    card.innerHTML = `
                        <div class="relative h-48 overflow-hidden">
                            <img src="${prop.image}" alt="${prop.title}" class="w-full h-full object-cover">
                            <div class="absolute top-3 right-3 flex flex-col gap-2">
                                <button class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center text-[var(--color-primary)] shadow-sm focus:outline-none" onclick="window.AuraCompare.remove('${prop.title}')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <p class="text-[var(--color-accent)] font-bold text-lg mb-1">${prop.price}</p>
                            <h3 class="font-heading font-bold text-gray-900 truncate mb-1">${prop.title}</h3>
                            <p class="text-xs text-gray-500 mb-4 truncate">${prop.location}</p>
                            
                            <div class="mt-auto border-t border-gray-100 pt-4 flex justify-between items-center text-xs text-gray-500 font-medium">
                                <span class="text-[var(--color-primary)] font-bold">${prop.type}</span>
                                <a href="${prop.url || '#'}" class="text-[var(--color-accent)] hover:underline font-bold">View Details</a>
                            </div>
                        </div>
                    `;
                    grid.appendChild(card);
                });
            }
        }

        // Initial render
        setTimeout(renderCompare, 100);

        // Listen for updates
        window.addEventListener('compare-updated', () => {
            renderCompare();
        });
    });
</script>
@endsection
