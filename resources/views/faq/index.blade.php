@extends('layouts.app')

@section('title', 'FAQ | Aura Real Estate')

@section('content')
<div class="pt-24 pb-20 bg-[var(--color-surface)] min-h-screen">
    
    <!-- FAQ HERO -->
    <div class="bg-[var(--color-primary)] text-white py-20 lg:py-28 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)] to-transparent z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-fade-up-scroll">
            <nav class="flex items-center justify-center text-sm text-gray-400 space-x-2 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <span class="text-white font-medium">FAQ</span>
            </nav>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold mb-6">How Can We Help You?</h1>
            <p class="text-gray-300 max-w-2xl mx-auto text-lg mb-10">Search our knowledge base or browse categories below to find answers to common questions about using Aura.</p>
            
            <!-- Global Search Box -->
            <div class="max-w-3xl mx-auto bg-white rounded-2xl p-2 shadow-2xl flex flex-col md:flex-row relative">
                <div class="flex-1 flex items-center px-4 py-3 border-gray-100">
                    <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" id="faqSearchInput" placeholder="Search for keywords like 'rent', 'buy', 'agent'..." class="w-full focus:outline-none text-gray-800 placeholder-gray-400 bg-transparent text-sm">
                    <button id="clearSearchBtn" class="hidden text-gray-400 hover:text-gray-600 focus:outline-none ml-2 p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        
        <!-- Category Filter -->
        <div class="flex flex-nowrap overflow-x-auto pb-4 mb-10 gap-3 scrollbar-hide animate-fade-up-scroll" id="faqCategoryFilters">
            <button class="faq-filter-btn active flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent bg-[var(--color-primary)] text-white" data-filter="all">All</button>
            <button class="faq-filter-btn flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent bg-white text-gray-600 hover:border-gray-300" data-filter="general">General</button>
            <button class="faq-filter-btn flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent bg-white text-gray-600 hover:border-gray-300" data-filter="buying">Buying</button>
            <button class="faq-filter-btn flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent bg-white text-gray-600 hover:border-gray-300" data-filter="renting">Renting</button>
            <button class="faq-filter-btn flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent bg-white text-gray-600 hover:border-gray-300" data-filter="selling">Selling / Listing</button>
            <button class="faq-filter-btn flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent bg-white text-gray-600 hover:border-gray-300" data-filter="account">Account</button>
        </div>

        <!-- FAQ ACCORDION LIST -->
        <div class="max-w-4xl mx-auto animate-fade-up-scroll" style="animation-delay: 0.1s;">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden" id="faqContainer">
                
                <!-- General -->
                <div class="faq-item border-b border-gray-100" data-category="general">
                    <button class="w-full text-left px-6 py-6 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-bold text-lg text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">How can I search for a property?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-500 hidden faq-content text-base leading-relaxed">
                        You can search for properties by visiting our Home page and using the main search bar, or navigate to our Properties page to apply detailed filters like price range, location, bedrooms, and property type.
                    </div>
                </div>

                <!-- Buying -->
                <div class="faq-item border-b border-gray-100" data-category="buying">
                    <button class="w-full text-left px-6 py-6 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-bold text-lg text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">Can I filter properties by location and price?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-500 hidden faq-content text-base leading-relaxed">
                        Yes, our advanced search allows you to filter listings by precise locations (City and Area), set minimum and maximum price ranges, and narrow down by property type (e.g., House, Apartment, Penthouse).
                    </div>
                </div>

                <!-- Account / Favorites -->
                <div class="faq-item border-b border-gray-100" data-category="account">
                    <button class="w-full text-left px-6 py-6 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-bold text-lg text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">How can I save a property?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-500 hidden faq-content text-base leading-relaxed">
                        Click the Heart icon on any property card or detail page. This instantly adds the property to your Favorites, which you can access anytime by clicking the Heart icon in the main navigation menu.
                    </div>
                </div>

                <!-- Account / Favorites -->
                <div class="faq-item border-b border-gray-100" data-category="account">
                    <button class="w-full text-left px-6 py-6 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-bold text-lg text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">How can I remove a saved property?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-500 hidden faq-content text-base leading-relaxed">
                        To remove a saved property, navigate to the Favorites page and click the red Trash icon on the property card. Alternatively, you can click the Heart icon again on the property itself to un-save it.
                    </div>
                </div>

                <!-- Account / Compare -->
                <div class="faq-item border-b border-gray-100" data-category="account">
                    <button class="w-full text-left px-6 py-6 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-bold text-lg text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">How does property comparison work?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-500 hidden faq-content text-base leading-relaxed">
                        Click the Scales/Compare icon on up to 4 property cards. Then navigate to the Compare page from the navigation bar. You'll see a side-by-side table of features. You can also toggle "Highlight Differences" to easily see what makes them unique.
                    </div>
                </div>

                <!-- General -->
                <div class="faq-item border-b border-gray-100" data-category="general">
                    <button class="w-full text-left px-6 py-6 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-bold text-lg text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">How can I contact an agent?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-500 hidden faq-content text-base leading-relaxed">
                        Every property details page includes the listing agent's contact information. You can use the buttons to Call, WhatsApp, or click "Go to Inquiry Form" to send a structured message directly from the platform.
                    </div>
                </div>

                <!-- Selling -->
                <div class="faq-item border-b border-gray-100" data-category="selling">
                    <button class="w-full text-left px-6 py-6 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-bold text-lg text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">How can I list my property?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-500 hidden faq-content text-base leading-relaxed">
                        Property owners and agents can list properties by clicking the "List Property" button in the navigation bar. You will be guided through a submission wizard to enter details, upload media, and submit for review.
                    </div>
                </div>

                <!-- General -->
                <div class="faq-item border-b border-gray-100" data-category="general">
                    <button class="w-full text-left px-6 py-6 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-bold text-lg text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">Can I explore property projects?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-500 hidden faq-content text-base leading-relaxed">
                        Yes, navigate to the Projects section to browse entirely new developments. Project pages provide detailed overviews, unit availability, master plans, and exclusive developer information.
                    </div>
                </div>

                <!-- General -->
                <div class="faq-item border-b border-gray-100" data-category="general">
                    <button class="w-full text-left px-6 py-6 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-bold text-lg text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">How can I find properties in a specific area?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-500 hidden faq-content text-base leading-relaxed">
                        Use the Locations Directory from the navigation menu to browse popular cities and specific neighborhoods. Selecting an area will automatically load properties available in that specific region.
                    </div>
                </div>

                <!-- Buying / Renting -->
                <div class="faq-item border-b border-gray-100" data-category="general">
                    <button class="w-full text-left px-6 py-6 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-bold text-lg text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">Can I submit an inquiry about a property?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-500 hidden faq-content text-base leading-relaxed">
                        Yes, every property has a direct connection to our centralized Contact form. The form will automatically attach the property's name so the agent knows exactly which listing you are referring to.
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div id="faqEmptyState" class="hidden text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-2">No results found</h3>
                <p class="text-gray-500">We couldn't find any FAQs matching your search criteria.</p>
                <button id="resetSearchBtn" class="mt-6 text-[var(--color-accent)] font-bold hover:underline">Clear Search</button>
            </div>
        </div>
    </div>

    <!-- CTA SECTION -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
        <div class="bg-[var(--color-primary)] rounded-3xl p-10 md:p-16 text-center text-white relative overflow-hidden shadow-2xl animate-fade-up-scroll">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="relative z-10">
                <h2 class="font-heading text-3xl md:text-4xl font-bold mb-6">Still have questions?</h2>
                <p class="text-gray-300 max-w-2xl mx-auto text-lg mb-10">If you couldn't find the answer to your question, our support team is ready to help you directly.</p>
                <a href="{{ route('contact.index') }}" class="inline-block bg-[var(--color-accent)] hover:bg-yellow-500 text-[var(--color-primary)] font-bold py-4 px-10 rounded-xl transition-colors shadow-md">
                    Contact Support
                </a>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const faqBtns = document.querySelectorAll('.faq-btn');
        const filterBtns = document.querySelectorAll('.faq-filter-btn');
        const faqItems = document.querySelectorAll('.faq-item');
        const searchInput = document.getElementById('faqSearchInput');
        const clearSearchBtn = document.getElementById('clearSearchBtn');
        const emptyState = document.getElementById('faqEmptyState');
        const resetSearchBtn = document.getElementById('resetSearchBtn');

        let currentFilter = 'all';
        let currentSearch = '';

        // Accordion Logic
        faqBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const content = btn.nextElementSibling;
                const icon = btn.querySelector('.faq-icon');
                const isExpanded = btn.getAttribute('aria-expanded') === 'true';
                
                // Close others
                faqBtns.forEach(otherBtn => {
                    if (otherBtn !== btn) {
                        otherBtn.setAttribute('aria-expanded', 'false');
                        otherBtn.nextElementSibling.classList.add('hidden');
                        otherBtn.querySelector('.faq-icon').classList.remove('rotate-180');
                    }
                });

                // Toggle
                if (isExpanded) {
                    btn.setAttribute('aria-expanded', 'false');
                    content.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                } else {
                    btn.setAttribute('aria-expanded', 'true');
                    content.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                }
            });
        });

        // Filter & Search Logic
        function updateDisplay() {
            let visibleCount = 0;
            
            faqItems.forEach(item => {
                const category = item.getAttribute('data-category');
                const questionText = item.querySelector('span').innerText.toLowerCase();
                const answerText = item.querySelector('.faq-content').innerText.toLowerCase();
                
                const matchesCategory = currentFilter === 'all' || category === currentFilter;
                const matchesSearch = currentSearch === '' || 
                                      questionText.includes(currentSearch) || 
                                      answerText.includes(currentSearch);

                if (matchesCategory && matchesSearch) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                    // Close if hiding
                    const btn = item.querySelector('.faq-btn');
                    btn.setAttribute('aria-expanded', 'false');
                    btn.nextElementSibling.classList.add('hidden');
                    btn.querySelector('.faq-icon').classList.remove('rotate-180');
                }
            });

            if (visibleCount === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        // Category Filter Clicks
        filterBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                // Update active state
                filterBtns.forEach(b => {
                    b.classList.remove('bg-[var(--color-primary)]', 'text-white');
                    b.classList.add('bg-white', 'text-gray-600');
                });
                e.target.classList.remove('bg-white', 'text-gray-600');
                e.target.classList.add('bg-[var(--color-primary)]', 'text-white');

                currentFilter = e.target.getAttribute('data-filter');
                updateDisplay();
            });
        });

        // Search Input
        searchInput.addEventListener('input', (e) => {
            currentSearch = e.target.value.toLowerCase().trim();
            if (currentSearch.length > 0) {
                clearSearchBtn.classList.remove('hidden');
            } else {
                clearSearchBtn.classList.add('hidden');
            }
            updateDisplay();
        });

        // Clear Search
        function clearSearch() {
            searchInput.value = '';
            currentSearch = '';
            clearSearchBtn.classList.add('hidden');
            
            // Reset filter to All if clearing from empty state
            document.querySelector('[data-filter="all"]').click();
        }

        clearSearchBtn.addEventListener('click', clearSearch);
        resetSearchBtn.addEventListener('click', clearSearch);
    });
</script>
@endsection
