@extends('layouts.app')

@section('title', 'Article Details | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-white min-h-screen">
    
    <!-- HEADER SECTION -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-10 text-center animate-fade-up-scroll">
        <nav class="flex items-center justify-center text-sm text-gray-400 space-x-2 mb-8">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('blog.index') }}" class="hover:text-[var(--color-primary)] transition-colors">Blog</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium truncate max-w-xs">The Global Real Estate Market Outlook for 2027</span>
        </nav>
        
        <a href="{{ route('blog.category', 'market-insights') }}" class="inline-block bg-[var(--color-accent)]/10 text-[var(--color-accent)] font-bold text-xs px-3 py-1.5 rounded-full uppercase tracking-wider mb-6 hover:bg-[var(--color-accent)] hover:text-white transition-colors">
            Market Insights
        </a>
        
        <h1 class="font-heading text-3xl md:text-5xl lg:text-6xl font-bold text-[var(--color-primary)] mb-6 leading-tight">
            The Global Real Estate Market Outlook for 2027
        </h1>
        
        <p class="text-xl text-gray-500 mb-8 max-w-2xl mx-auto leading-relaxed">
            An in-depth analysis of emerging trends, shifting buyer preferences, and where high-net-worth individuals are investing their capital in the coming year.
        </p>
        
        <div class="flex items-center justify-center text-sm text-gray-500 space-x-6 font-medium border-t border-b border-gray-100 py-4">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-gray-200 mr-3 overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=random" alt="Dr. Sarah Jenkins">
                </div>
                <span>Dr. Sarah Jenkins</span>
            </div>
            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full hidden sm:block"></span>
            <span class="hidden sm:block">October 24, 2026</span>
            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full hidden sm:block"></span>
            <span class="hidden sm:flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                12 min read
            </span>
        </div>
    </div>

    <!-- HERO IMAGE -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 animate-fade-up-scroll">
        <div class="rounded-3xl overflow-hidden shadow-2xl relative h-[400px] md:h-[600px]">
            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=1746&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
    </div>

    <!-- ARTICLE LAYOUT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-12">
        
        <!-- Social Share Sidebar (Desktop) -->
        <div class="hidden lg:block w-16 flex-shrink-0 animate-fade-up-scroll">
            <div class="sticky top-32 flex flex-col space-y-4">
                <button class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-[#1877F2] hover:text-white transition-colors shadow-sm" aria-label="Share on Facebook">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </button>
                <button class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-[#0A66C2] hover:text-white transition-colors shadow-sm" aria-label="Share on LinkedIn">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </button>
                <button class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-[#25D366] hover:text-white transition-colors shadow-sm" aria-label="Share on WhatsApp">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </button>
                <button class="copy-link-btn w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-gray-200 hover:text-[var(--color-primary)] transition-colors shadow-sm" aria-label="Copy Link">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                </button>
            </div>
        </div>

        <!-- Main Content Area -->
        <article class="flex-grow max-w-3xl animate-fade-up-scroll" style="animation-delay: 0.1s;">
            
            <div class="prose prose-lg prose-gray max-w-none">
                <p>The global real estate market is poised for significant transformation as we approach 2027. Driven by changing demographics, technological advancements, and shifting macroeconomic factors, investors are rethinking their strategies to capitalize on emerging opportunities.</p>
                
                <h2>1. The Rise of Secondary Tier Cities</h2>
                <p>While global capitals like London, New York, and Tokyo remain stalwarts of luxury real estate, secondary cities are experiencing unprecedented growth. Cities offering a high quality of life, favorable tax environments, and robust tech infrastructures are drawing both corporations and high-net-worth individuals.</p>
                <ul>
                    <li>Austin, Texas continues to attract tech talent and venture capital.</li>
                    <li>Lisbon, Portugal offers a compelling mix of lifestyle and favorable visa programs.</li>
                    <li>Brisbane, Australia is seeing a surge in infrastructure investment ahead of future global events.</li>
                </ul>

                <blockquote>
                    "The definition of prime real estate is expanding beyond traditional geographic boundaries. Investors are increasingly prioritizing lifestyle factors, sustainability, and community resilience over legacy zip codes."
                </blockquote>

                <h2>2. Sustainable and Wellness-Centric Developments</h2>
                <p>Environmental, Social, and Governance (ESG) criteria are no longer optional for major developments. Properties that fail to meet rigorous sustainability standards are facing a "brown discount," while certified green buildings command premium rents and higher capital values.</p>
                <p>Furthermore, the integration of wellness amenities—such as advanced air purification systems, circadian lighting, and biophilic design—has transitioned from a luxury perk to a baseline expectation in high-end residential projects.</p>

                <figure>
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=1665&auto=format&fit=crop" alt="Sustainable modern architecture with vertical gardens" class="rounded-xl shadow-md">
                    <figcaption class="text-center text-sm text-gray-500 mt-3">Biophilic design is becoming standard in luxury urban developments.</figcaption>
                </figure>

                <h2>3. The Fractionalization of Assets</h2>
                <p>Blockchain technology and tokenization are beginning to democratize access to prime real estate. By allowing assets to be divided into smaller, tradable digital tokens, developers can access global capital pools more efficiently, while retail investors gain exposure to institutional-grade properties.</p>

                <h2>Conclusion</h2>
                <p>Navigating the real estate landscape in 2027 will require agility and a forward-looking approach. Whether you are seeking a primary residence that supports a hybrid lifestyle or diversifying an investment portfolio, understanding these macro trends is crucial for long-term success.</p>
            </div>

            <!-- Tags -->
            <div class="mt-12 flex flex-wrap gap-2">
                <a href="#" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors">Market Trends</a>
                <a href="#" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors">Investment</a>
                <a href="#" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors">Global</a>
                <a href="#" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors">Luxury</a>
            </div>

            <!-- Mobile Social Share -->
            <div class="lg:hidden flex items-center justify-center space-x-4 mt-12 py-8 border-t border-b border-gray-100">
                <span class="text-gray-500 font-medium mr-2">Share:</span>
                <button class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-[#1877F2] hover:text-white transition-colors" aria-label="Share on Facebook"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></button>
                <button class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-[#0A66C2] hover:text-white transition-colors" aria-label="Share on LinkedIn"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></button>
                <button class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-[#25D366] hover:text-white transition-colors" aria-label="Share on WhatsApp"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></button>
                <button class="copy-link-btn w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-gray-200 hover:text-[var(--color-primary)] transition-colors" aria-label="Copy Link"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg></button>
            </div>
            
        </article>

        <!-- Right Sidebar -->
        <aside class="w-full lg:w-80 flex-shrink-0 animate-fade-up-scroll" style="animation-delay: 0.2s;">
            
            <!-- Table of Contents -->
            <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-100">
                <h3 class="font-heading font-bold text-lg text-[var(--color-primary)] mb-4 border-b border-gray-200 pb-2">Contents</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="text-[var(--color-accent)] font-medium hover:underline">1. The Rise of Secondary Tier Cities</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-[var(--color-primary)] transition-colors">2. Sustainable and Wellness-Centric Developments</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-[var(--color-primary)] transition-colors">3. The Fractionalization of Assets</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-[var(--color-primary)] transition-colors">Conclusion</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="bg-white rounded-2xl p-6 mb-8 shadow-sm border border-gray-100">
                <h3 class="font-heading font-bold text-lg text-[var(--color-primary)] mb-4">Categories</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('blog.category', 'buying-guide') }}" class="flex justify-between items-center text-sm text-gray-600 hover:text-[var(--color-accent)] transition-colors py-1 group"><span>Buying Guide</span><span class="bg-gray-100 text-gray-500 rounded-full px-2 py-0.5 text-xs group-hover:bg-[var(--color-accent)]/10 group-hover:text-[var(--color-accent)]">12</span></a></li>
                    <li><a href="{{ route('blog.category', 'selling-guide') }}" class="flex justify-between items-center text-sm text-gray-600 hover:text-[var(--color-accent)] transition-colors py-1 group"><span>Selling Guide</span><span class="bg-gray-100 text-gray-500 rounded-full px-2 py-0.5 text-xs group-hover:bg-[var(--color-accent)]/10 group-hover:text-[var(--color-accent)]">8</span></a></li>
                    <li><a href="{{ route('blog.category', 'property-investment') }}" class="flex justify-between items-center text-sm text-gray-600 hover:text-[var(--color-accent)] transition-colors py-1 group"><span>Property Investment</span><span class="bg-gray-100 text-gray-500 rounded-full px-2 py-0.5 text-xs group-hover:bg-[var(--color-accent)]/10 group-hover:text-[var(--color-accent)]">15</span></a></li>
                    <li><a href="{{ route('blog.category', 'market-insights') }}" class="flex justify-between items-center text-sm text-[var(--color-accent)] font-semibold py-1"><span>Market Insights</span><span class="bg-[var(--color-accent)]/10 text-[var(--color-accent)] rounded-full px-2 py-0.5 text-xs">24</span></a></li>
                </ul>
            </div>

            <!-- Newsletter Signup -->
            <div class="bg-[var(--color-primary)] rounded-2xl p-6 text-white mb-8 shadow-lg relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
                <div class="relative z-10">
                    <h3 class="font-heading font-bold text-xl mb-2 text-white">Join our Newsletter</h3>
                    <p class="text-gray-300 text-sm mb-6">Get weekly insights, market reports, and exclusive listings straight to your inbox.</p>
                    <form id="newsletterForm" class="flex flex-col gap-3" onsubmit="event.preventDefault(); handleNewsletter();">
                        <input type="email" id="newsletterEmail" required placeholder="Your email address" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[var(--color-accent)]">
                        <button type="submit" id="newsletterBtn" class="w-full bg-[var(--color-accent)] hover:bg-yellow-500 text-[var(--color-primary)] font-bold rounded-lg px-4 py-3 text-sm transition-colors flex items-center justify-center">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

        </aside>

    </div>

    <!-- RELATED PROPERTIES -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24 mb-12 border-t border-gray-100 pt-16">
        <h2 class="font-heading text-3xl font-bold text-[var(--color-primary)] mb-8">Properties Mentioned in this Report</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-property-card 
                image="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1775&auto=format&fit=crop" 
                title="The Crown Penthouse" 
                location="Downtown Dubai" 
                type="Penthouse" 
                status="For Sale" 
                price="$12,500,000" 
                bedrooms="4" 
                bathrooms="5" 
                area="6,200 sqft"
                :featured="true"
            />
            <x-property-card 
                image="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=1770&auto=format&fit=crop" 
                title="Aston Martin Residences" 
                location="Miami, FL" 
                type="Apartment" 
                status="Pre-Construction" 
                price="$8,200,000" 
                bedrooms="3" 
                bathrooms="3.5" 
                area="3,800 sqft"
            />
        </div>
    </div>
</div>

<style>
    .prose h2 {
        font-family: 'Playfair Display', serif;
        color: var(--color-primary);
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
    }
    .prose p {
        color: #4b5563;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }
    .prose ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
        color: #4b5563;
    }
    .prose li {
        margin-bottom: 0.5rem;
    }
    .prose blockquote {
        border-left: 4px solid var(--color-accent);
        padding-left: 1.5rem;
        font-style: italic;
        color: #374151;
        margin: 2rem 0;
        font-size: 1.125rem;
    }
</style>

<script>
    // Copy link functionality
    document.querySelectorAll('.copy-link-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            navigator.clipboard.writeText(window.location.href).then(() => {
                if(window.AuraToast) window.AuraToast.show('Link copied to clipboard!', 'success');
            });
        });
    });

    // Newsletter mock handler
    function handleNewsletter() {
        const email = document.getElementById('newsletterEmail').value;
        const btn = document.getElementById('newsletterBtn');
        
        if(email) {
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-[var(--color-primary)]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            btn.disabled = true;
            
            setTimeout(() => {
                document.getElementById('newsletterEmail').value = '';
                btn.innerHTML = 'Subscribed!';
                btn.classList.replace('bg-[var(--color-accent)]', 'bg-green-500');
                btn.classList.replace('text-[var(--color-primary)]', 'text-white');
                if(window.AuraToast) window.AuraToast.show('Successfully subscribed to newsletter!', 'success');
                
                setTimeout(() => {
                    btn.innerHTML = 'Subscribe';
                    btn.classList.replace('bg-green-500', 'bg-[var(--color-accent)]');
                    btn.classList.replace('text-white', 'text-[var(--color-primary)]');
                    btn.disabled = false;
                }, 3000);
            }, 1000);
        }
    }
</script>
@endsection
