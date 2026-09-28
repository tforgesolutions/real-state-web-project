@extends('layouts.app')

@section('title', 'Saved Properties | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen flex flex-col">
    
    <!-- PAGE HEADER -->
    <div class="bg-[var(--color-primary)] text-white py-12 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 animate-fade-up-scroll">
            <nav class="flex items-center text-sm text-gray-400 space-x-2 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <span class="text-white">Favorites</span>
            </nav>
            <h1 class="font-heading text-3xl md:text-4xl font-bold mb-2">Saved Properties</h1>
            <p class="text-gray-400">Review the properties you've saved. Login to sync across devices.</p>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 flex-grow w-full">
        
        <!-- Controls Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8" id="controlsBar" style="display: none;">
            <div class="flex items-center gap-2 mb-4 sm:mb-0">
                <span class="text-sm text-gray-500 font-semibold uppercase tracking-wider"><span id="savedCountText">0</span> Properties</span>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Sort -->
                <div class="relative">
                    <select id="sortSelect" class="appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-2 pl-4 pr-10 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] text-sm font-medium">
                        <option value="recent">Recently Saved</option>
                        <option value="price_low">Price (Low to High)</option>
                        <option value="price_high">Price (High to Low)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <!-- Grid/List Toggle -->
                <div class="flex bg-gray-50 border border-gray-200 rounded-lg p-1">
                    <button id="viewGrid" class="p-1.5 rounded bg-white shadow-sm text-[var(--color-primary)] focus:outline-none transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </button>
                    <button id="viewList" class="p-1.5 rounded text-gray-400 hover:text-[var(--color-primary)] focus:outline-none transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Favorites Container -->
        <div id="favoritesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Populated by JS -->
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="flex flex-col items-center justify-center py-20 text-center animate-fade-up-scroll" style="display: none;">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-2">No saved properties yet</h2>
            <p class="text-gray-500 mb-8 max-w-md">Save properties you're interested in by clicking the heart icon on any property card, and come back to them anytime.</p>
            <a href="{{ route('properties.index') }}" class="btn-primary py-3 px-8 rounded-lg font-bold shadow-md">
                Explore Properties
            </a>
        </div>
        
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('favoritesContainer');
        const emptyState = document.getElementById('emptyState');
        const controlsBar = document.getElementById('controlsBar');
        const countText = document.getElementById('savedCountText');
        const sortSelect = document.getElementById('sortSelect');
        const viewGridBtn = document.getElementById('viewGrid');
        const viewListBtn = document.getElementById('viewList');
        
        let currentLayout = 'grid'; // grid or list

        function renderFavorites() {
            const favorites = window.AuraFavorites ? window.AuraFavorites.get() : [];
            
            if (favorites.length === 0) {
                container.style.display = 'none';
                controlsBar.style.display = 'none';
                emptyState.style.display = 'flex';
                return;
            }

            emptyState.style.display = 'none';
            controlsBar.style.display = 'flex';
            container.style.display = 'grid';
            countText.innerText = favorites.length;

            // Apply Sort
            const sortVal = sortSelect.value;
            let sorted = [...favorites];
            
            if (sortVal === 'price_low') {
                sorted.sort((a, b) => parsePrice(a.price) - parsePrice(b.price));
            } else if (sortVal === 'price_high') {
                sorted.sort((a, b) => parsePrice(b.price) - parsePrice(a.price));
            } else {
                // Recent (default - assuming appended to end originally)
                sorted.reverse();
            }

            // Apply Layout Classes
            if (currentLayout === 'list') {
                container.className = 'grid grid-cols-1 gap-6';
            } else {
                container.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8';
            }

            container.innerHTML = sorted.map(prop => generateCardHTML(prop, currentLayout)).join('');
            
            // Re-bind SVG state in newly generated HTML
            if(window.AuraFavorites) window.AuraFavorites.updateUI();
        }

        function parsePrice(priceStr) {
            if(!priceStr) return 0;
            // Remove $, commas, /mo
            return parseFloat(priceStr.replace(/[^0-9.-]+/g,"")) || 0;
        }

        function generateCardHTML(prop, layout) {
            const routePlaceholder = "#";
            
            if (layout === 'list') {
                return `
                <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col sm:flex-row h-auto sm:h-64 animate-fade-up-scroll relative">
                    <button type="button" class="favorite-btn hidden sm:block absolute top-4 right-4 p-2 bg-white/80 hover:bg-white text-red-500 rounded-full transition-colors backdrop-blur-sm focus:outline-none z-10 shadow-sm" data-title="${prop.title}" data-image="${prop.image}" data-location="${prop.location}" data-type="${prop.type}" data-status="${prop.status}" data-price="${prop.price}" data-bedrooms="${prop.bedrooms}" data-bathrooms="${prop.bathrooms}" data-area="${prop.area}">
                        <svg class="w-5 h-5 transition-colors fill-red-500" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <div class="relative w-full sm:w-2/5 h-48 sm:h-full overflow-hidden">
                        <img src="${prop.image}" alt="${prop.title}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            <span class="bg-[var(--color-primary)]/90 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm">${prop.status}</span>
                        </div>
                        <button type="button" class="favorite-btn sm:hidden absolute top-4 right-4 p-2 bg-white/80 hover:bg-white text-red-500 rounded-full transition-colors backdrop-blur-sm focus:outline-none z-10 shadow-sm" data-title="${prop.title}">
                            <svg class="w-5 h-5 transition-colors fill-red-500" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </div>
                    <div class="p-6 flex flex-col flex-grow w-full sm:w-3/5">
                        <div class="flex justify-between items-start mb-2 sm:pr-10">
                            <div class="text-xs text-[var(--color-accent)] font-semibold uppercase tracking-wider">${prop.type}</div>
                            <span class="text-[var(--color-primary)] font-bold text-xl">${prop.price}</span>
                        </div>
                        <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-2 group-hover:text-[var(--color-accent)] transition-colors line-clamp-1"><a href="${routePlaceholder}">${prop.title}</a></h3>
                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <svg class="w-4 h-4 mr-1 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="truncate">${prop.location}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 pt-4 mt-auto border-t border-gray-100">
                            <div class="flex items-center text-gray-600 text-sm">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                <span>${prop.bedrooms} Beds</span>
                            </div>
                            <div class="flex items-center text-gray-600 text-sm">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                <span>${prop.bathrooms} Baths</span>
                            </div>
                            <div class="flex items-center text-gray-600 text-sm">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                <span>${prop.area}</span>
                            </div>
                        </div>
                    </div>
                </div>`;
            } else {
                return `
                <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col h-full animate-fade-up-scroll">
                    <div class="relative h-64 overflow-hidden">
                        <a href="${routePlaceholder}">
                            <img src="${prop.image}" alt="${prop.title}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                        </a>
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            <span class="bg-[var(--color-primary)]/90 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm">${prop.status}</span>
                        </div>
                        <button type="button" class="favorite-btn absolute top-4 right-4 p-2 bg-white/80 hover:bg-white text-red-500 rounded-full transition-colors backdrop-blur-sm focus:outline-none z-10 shadow-sm" data-title="${prop.title}" data-image="${prop.image}" data-location="${prop.location}" data-type="${prop.type}" data-status="${prop.status}" data-price="${prop.price}" data-bedrooms="${prop.bedrooms}" data-bathrooms="${prop.bathrooms}" data-area="${prop.area}">
                            <svg class="w-5 h-5 transition-colors fill-red-500" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-white/95 text-[var(--color-primary)] font-bold px-4 py-1.5 rounded-lg shadow-lg backdrop-blur-sm">${prop.price}</span>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="text-xs text-[var(--color-accent)] font-semibold uppercase tracking-wider mb-2">${prop.type}</div>
                        <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-2 group-hover:text-[var(--color-accent)] transition-colors line-clamp-1"><a href="${routePlaceholder}">${prop.title}</a></h3>
                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <svg class="w-4 h-4 mr-1 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="truncate">${prop.location}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-4 mt-auto mb-6">
                            <div class="flex items-center text-gray-600 text-sm">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                <span>${prop.bedrooms} Beds</span>
                            </div>
                            <div class="flex items-center text-gray-600 text-sm">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                <span>${prop.bathrooms} Baths</span>
                            </div>
                            <div class="flex items-center text-gray-600 text-sm">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                <span>${prop.area}</span>
                            </div>
                        </div>
                        <a href="${routePlaceholder}" class="block w-full text-center py-3 border border-[var(--color-primary)] text-[var(--color-primary)] rounded-lg font-medium hover:bg-[var(--color-primary)] hover:text-white transition-colors duration-300">
                            View Details
                        </a>
                    </div>
                </div>`;
            }
        }

        // Listen for global favorite changes to re-render immediately
        window.addEventListener('favorites-updated', () => {
            renderFavorites();
        });

        // Event Listeners for controls
        sortSelect.addEventListener('change', renderFavorites);
        
        viewGridBtn.addEventListener('click', () => {
            currentLayout = 'grid';
            viewGridBtn.classList.replace('text-gray-400', 'text-[var(--color-primary)]');
            viewGridBtn.classList.add('bg-white', 'shadow-sm');
            viewListBtn.classList.replace('text-[var(--color-primary)]', 'text-gray-400');
            viewListBtn.classList.remove('bg-white', 'shadow-sm');
            renderFavorites();
        });

        viewListBtn.addEventListener('click', () => {
            currentLayout = 'list';
            viewListBtn.classList.replace('text-gray-400', 'text-[var(--color-primary)]');
            viewListBtn.classList.add('bg-white', 'shadow-sm');
            viewGridBtn.classList.replace('text-[var(--color-primary)]', 'text-gray-400');
            viewGridBtn.classList.remove('bg-white', 'shadow-sm');
            renderFavorites();
        });

        // Initial Render
        renderFavorites();
    });
</script>
@endsection
