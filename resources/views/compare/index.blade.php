@extends('layouts.app')

@section('title', 'Compare Properties | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen flex flex-col">
    
    <!-- PAGE HEADER -->
    <div class="bg-[var(--color-primary)] text-white py-12 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 animate-fade-up-scroll">
            <nav class="flex items-center text-sm text-gray-400 space-x-2 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <span class="text-white">Compare</span>
            </nav>
            <h1 class="font-heading text-3xl md:text-4xl font-bold mb-2">Compare Properties</h1>
            <p class="text-gray-400">Evaluate features, locations, and pricing side by side.</p>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 flex-grow w-full">
        
        <!-- Toolbar -->
        <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8" id="controlsBar" style="display: none;">
            <div class="flex items-center gap-2 mb-4 sm:mb-0">
                <span class="text-sm text-gray-500 font-semibold uppercase tracking-wider"><span id="compareCountText">0</span> Properties</span>
            </div>
            
            <div class="flex items-center gap-4">
                <label class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" id="highlightDiffToggle" class="sr-only">
                        <div class="block bg-gray-200 w-10 h-6 rounded-full transition-colors toggle-bg"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform transform"></div>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Highlight Differences</span>
                </label>

                <div class="w-px h-6 bg-gray-200"></div>

                <button id="clearAllBtn" class="text-sm font-medium text-red-500 hover:text-red-600 transition-colors focus:outline-none flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Clear All
                </button>
            </div>
        </div>

        <!-- Comparison Table Container -->
        <div id="compareContainer" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto relative animate-fade-up-scroll" style="display: none;">
            <table class="w-full text-left border-collapse min-w-[800px]" id="compareTable">
                <!-- Populated by JS -->
            </table>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="flex flex-col items-center justify-center py-20 text-center animate-fade-up-scroll" style="display: none;">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-2">No properties selected for comparison</h2>
            <p class="text-gray-500 mb-8 max-w-md">Add properties from the listings to compare their features side by side.</p>
            <a href="{{ route('properties.index') }}" class="btn-primary py-3 px-8 rounded-lg font-bold shadow-md">
                Explore Properties
            </a>
        </div>
        
    </div>
</div>

<style>
    /* Custom Toggle Styles */
    input:checked ~ .dot {
        transform: translateX(100%);
    }
    input:checked ~ .toggle-bg {
        background-color: var(--color-accent);
    }
    
    /* Table Styles */
    #compareTable th, #compareTable td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: top;
    }
    #compareTable tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .diff-highlight {
        background-color: #fffbeb !important; /* light yellow bg */
        color: #b45309; /* dark amber text */
        font-weight: 600;
        border-radius: 0.375rem;
        padding: 0.125rem 0.375rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('compareContainer');
        const emptyState = document.getElementById('emptyState');
        const controlsBar = document.getElementById('controlsBar');
        const countText = document.getElementById('compareCountText');
        const compareTable = document.getElementById('compareTable');
        const clearAllBtn = document.getElementById('clearAllBtn');
        const highlightToggle = document.getElementById('highlightDiffToggle');
        
        let highlightDifferences = false;

        function renderComparison() {
            const properties = window.AuraCompare ? window.AuraCompare.get() : [];
            
            if (properties.length === 0) {
                container.style.display = 'none';
                controlsBar.style.display = 'none';
                emptyState.style.display = 'flex';
                return;
            }

            emptyState.style.display = 'none';
            controlsBar.style.display = 'flex';
            container.style.display = 'block';
            countText.innerText = properties.length;

            buildTable(properties);
        }

        function buildTable(props) {
            const routePlaceholder = "#";
            
            // Build Headers
            let theadHtml = `
                <thead>
                    <tr>
                        <th class="w-1/5 bg-gray-50 border-b border-gray-200"></th>
                        ${props.map(p => `
                            <th class="w-1/4 bg-gray-50 border-b border-gray-200 font-normal">
                                <div class="relative bg-white rounded-lg overflow-hidden shadow-sm border border-gray-100 h-40">
                                    <img src="${p.image}" class="w-full h-24 object-cover" alt="Image">
                                    <button class="remove-compare-btn absolute top-2 right-2 p-1.5 bg-white/90 hover:bg-red-500 text-gray-500 hover:text-white rounded-full transition-colors shadow-sm focus:outline-none" data-title="${p.title}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                    <div class="p-2">
                                        <h3 class="font-bold text-[var(--color-primary)] text-sm truncate">${p.title}</h3>
                                        <span class="text-xs font-semibold text-[var(--color-accent)]">${p.status}</span>
                                    </div>
                                </div>
                            </th>
                        `).join('')}
                    </tr>
                </thead>
            `;

            // Row Helper
            const buildRow = (label, key, isDiffable = false) => {
                let isDifferent = false;
                if (isDiffable && highlightDifferences && props.length > 1) {
                    const firstVal = props[0][key];
                    isDifferent = props.some(p => p[key] !== firstVal);
                }

                const cells = props.map(p => {
                    let val = p[key] || '-';
                    let cssClass = 'text-gray-700 font-medium';
                    if (isDifferent) {
                        cssClass += ' diff-highlight';
                    }
                    return `<td class="border-b border-gray-100"><span class="${cssClass}">${val}</span></td>`;
                }).join('');

                return `
                    <tr>
                        <td class="font-semibold text-gray-500 text-sm uppercase tracking-wider bg-gray-50/50">${label}</td>
                        ${cells}
                    </tr>
                `;
            };

            let tbodyHtml = `
                <tbody>
                    ${buildRow('Price', 'price', true)}
                    ${buildRow('Property Type', 'type', true)}
                    ${buildRow('Location', 'location', false)}
                    ${buildRow('Bedrooms', 'bedrooms', true)}
                    ${buildRow('Bathrooms', 'bathrooms', true)}
                    ${buildRow('Area', 'area', true)}
                    <tr>
                        <td class="font-semibold text-gray-500 text-sm uppercase tracking-wider bg-gray-50/50 pt-6"></td>
                        ${props.map(p => `
                            <td class="pt-6">
                                <a href="${routePlaceholder}" class="block w-full text-center py-2.5 bg-[var(--color-primary)] text-white rounded-lg font-medium hover:bg-[var(--color-primary-light)] transition-colors shadow-sm">View Details</a>
                            </td>
                        `).join('')}
                    </tr>
                </tbody>
            `;

            compareTable.innerHTML = theadHtml + tbodyHtml;

            // Bind remove buttons
            document.querySelectorAll('.remove-compare-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const title = btn.dataset.title;
                    if(window.AuraCompare) {
                        // Dummy obj just for title lookup in toggle
                        window.AuraCompare.toggle({title: title}); 
                    }
                });
            });
        }

        // Listen for global compare changes
        window.addEventListener('compare-updated', () => {
            renderComparison();
        });

        clearAllBtn.addEventListener('click', () => {
            if(window.AuraCompare) window.AuraCompare.clear();
        });

        highlightToggle.addEventListener('change', (e) => {
            highlightDifferences = e.target.checked;
            renderComparison();
        });

        // Initial Render
        renderComparison();
    });
</script>
@endsection
