@extends('layouts.app')

@section('title', 'Saved Properties | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('account.index') }}" class="hover:text-[var(--color-primary)] transition-colors">My Account</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">Saved Properties</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden min-h-[600px]">
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] flex items-center">
                            Saved Properties <span id="favPageCount" class="ml-3 bg-[var(--color-accent)]/10 text-[var(--color-accent)] text-sm px-3 py-1 rounded-full font-bold">0</span>
                        </h2>
                    </div>
                    
                    <div class="p-8">
                        <div id="favoritesGrid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Populated by JS -->
                        </div>

                        <!-- Empty State -->
                        <div id="favoritesEmptyState" class="hidden text-center py-20">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-3">No saved properties</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">You haven't added any properties to your favorites yet. Start exploring to find your dream home.</p>
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
        const grid = document.getElementById('favoritesGrid');
        const emptyState = document.getElementById('favoritesEmptyState');
        const favCount = document.getElementById('favPageCount');

        function renderFavorites() {
            if(!window.AuraFavorites) return;
            
            const favorites = window.AuraFavorites.get();
            favCount.innerText = favorites.length;

            if (favorites.length === 0) {
                grid.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
                grid.classList.remove('hidden');
                
                grid.innerHTML = '';
                
                favorites.forEach(prop => {
                    const card = document.createElement('div');
                    card.className = 'bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 flex flex-col relative group';
                    card.innerHTML = `
                        <div class="relative h-48 overflow-hidden">
                            <img src="${prop.image}" alt="${prop.title}" class="w-full h-full object-cover">
                            <div class="absolute top-3 right-3 flex flex-col gap-2">
                                <button class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center text-red-500 shadow-sm focus:outline-none" onclick="window.AuraFavorites.remove('${prop.title}')">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <p class="text-[var(--color-accent)] font-bold text-lg mb-1">${prop.price}</p>
                            <h3 class="font-heading font-bold text-gray-900 truncate mb-1">${prop.title}</h3>
                            <p class="text-xs text-gray-500 mb-4 truncate">${prop.location}</p>
                            
                            <div class="mt-auto border-t border-gray-100 pt-4 flex justify-between items-center text-xs text-gray-500 font-medium">
                                <div class="flex items-center space-x-3">
                                    <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>${prop.bedrooms || '-'}</span>
                                    <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>${prop.bathrooms || '-'}</span>
                                </div>
                                <span class="text-[var(--color-primary)] font-bold">${prop.type}</span>
                            </div>
                        </div>
                    `;
                    grid.appendChild(card);
                });
            }
        }

        // Initial render
        setTimeout(renderFavorites, 100);

        // Listen for updates
        window.addEventListener('favorites-updated', () => {
            renderFavorites();
        });
    });
</script>
@endsection
