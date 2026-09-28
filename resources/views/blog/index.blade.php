@extends('layouts.app')

@section('title', 'News & Insights | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- PAGE HEADER -->
    <div class="bg-[var(--color-primary)] text-white py-16 lg:py-24 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1769&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)] to-transparent z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-fade-up-scroll">
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-white">Real Estate Insights</h1>
            <p class="text-gray-300 max-w-2xl mx-auto text-lg mb-10">Expert market analysis, investment guides, and the latest trends in luxury real estate.</p>
            
            <!-- Global Search Box -->
            <div class="max-w-3xl mx-auto bg-white rounded-2xl p-2 shadow-2xl flex flex-col md:flex-row">
                <div class="flex-1 flex items-center px-4 py-3 border-gray-100">
                    <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Search articles, guides, or market reports..." class="w-full focus:outline-none text-gray-800 placeholder-gray-400 bg-transparent text-sm">
                </div>
                <button class="md:w-32 bg-[var(--color-accent)] hover:bg-yellow-500 text-[var(--color-primary)] font-bold py-3 md:py-3 rounded-xl transition-colors mt-2 md:mt-0 flex-shrink-0">
                    Search
                </button>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        
        <!-- Category Filter -->
        <div class="flex flex-nowrap overflow-x-auto pb-4 mb-10 gap-3 scrollbar-hide animate-fade-up-scroll" style="animation-delay: 0.1s;">
            <a href="{{ route('blog.index') }}" class="flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent {{ !isset($category) ? 'bg-[var(--color-primary)] text-white' : 'bg-white text-gray-600 hover:border-gray-300' }}">All Articles</a>
            <a href="{{ route('blog.category', 'buying-guide') }}" class="flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent {{ isset($category) && $category === 'buying-guide' ? 'bg-[var(--color-primary)] text-white' : 'bg-white text-gray-600 hover:border-gray-300' }}">Buying Guide</a>
            <a href="{{ route('blog.category', 'market-insights') }}" class="flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent {{ isset($category) && $category === 'market-insights' ? 'bg-[var(--color-primary)] text-white' : 'bg-white text-gray-600 hover:border-gray-300' }}">Market Insights</a>
            <a href="{{ route('blog.category', 'property-investment') }}" class="flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent {{ isset($category) && $category === 'property-investment' ? 'bg-[var(--color-primary)] text-white' : 'bg-white text-gray-600 hover:border-gray-300' }}">Property Investment</a>
            <a href="{{ route('blog.category', 'home-lifestyle') }}" class="flex-shrink-0 px-6 py-2.5 rounded-full text-sm font-bold transition-colors shadow-sm border border-transparent {{ isset($category) && $category === 'home-lifestyle' ? 'bg-[var(--color-primary)] text-white' : 'bg-white text-gray-600 hover:border-gray-300' }}">Home & Lifestyle</a>
        </div>

        @if(!isset($category))
        <!-- FEATURED ARTICLE -->
        <div class="mb-16 animate-fade-up-scroll" style="animation-delay: 0.2s;">
            <article class="relative rounded-3xl overflow-hidden shadow-xl group">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=1746&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-in-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                </div>
                
                <div class="relative z-10 p-8 md:p-16 flex flex-col justify-end min-h-[500px] max-w-4xl">
                    <span class="bg-[var(--color-accent)] text-white text-xs font-bold px-4 py-2 rounded-full uppercase tracking-widest inline-block w-max mb-6">Featured</span>
                    
                    <h2 class="font-heading text-3xl md:text-5xl font-bold text-white mb-4 drop-shadow-md">
                        <a href="{{ route('blog.show', 'global-real-estate-market-outlook-2027') }}" class="hover:text-[var(--color-accent)] transition-colors">The Global Real Estate Market Outlook for 2027</a>
                    </h2>
                    
                    <p class="text-gray-300 text-lg md:text-xl mb-8 line-clamp-2 md:line-clamp-none max-w-2xl drop-shadow-md">
                        An in-depth analysis of emerging trends, shifting buyer preferences, and where high-net-worth individuals are investing their capital in the coming year.
                    </p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-300 space-x-4 font-medium uppercase tracking-wide">
                            <span>By Dr. Sarah Jenkins</span>
                            <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                            <span>October 24, 2026</span>
                        </div>
                        <a href="{{ route('blog.show', 'global-real-estate-market-outlook-2027') }}" class="hidden md:flex items-center text-white font-bold hover:text-[var(--color-accent)] transition-colors group-hover:translate-x-2 transform duration-300">
                            Read Full Report
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </article>
        </div>
        @endif

        <!-- ARTICLES GRID -->
        <div class="flex justify-between items-end mb-8 animate-fade-up-scroll" style="animation-delay: 0.3s;">
            <div>
                <h2 class="font-heading text-3xl font-bold text-[var(--color-primary)]">Latest Articles</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <x-blog-card 
                title="5 Key Factors to Consider When Buying a Luxury Apartment"
                excerpt="From location and amenities to future resale value, discover the crucial elements that distinguish a good investment from a great one."
                category="Buying Guide"
                image="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1740&auto=format&fit=crop"
                date="Oct 20, 2026"
                readTime="6 min read"
            />
            
            <x-blog-card 
                title="How Sustainable Architecture is Reshaping Urban Living"
                excerpt="Green buildings aren't just good for the environment—they command higher premiums and attract a new generation of eco-conscious buyers."
                category="Market Insights"
                image="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=1665&auto=format&fit=crop"
                date="Oct 15, 2026"
                readTime="8 min read"
            />

            <x-blog-card 
                title="Maximizing ROI on Commercial Property Investments"
                excerpt="A comprehensive guide to analyzing cap rates, tenant retention strategies, and value-add opportunities in commercial real estate."
                category="Property Investment"
                image="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1740&auto=format&fit=crop"
                date="Oct 12, 2026"
                readTime="10 min read"
            />

            <x-blog-card 
                title="Interior Design Trends Defining Luxury Homes This Year"
                excerpt="Explore the shift towards biophilic design, smart home integration, and bespoke artisanal finishes in high-end residences."
                category="Home & Lifestyle"
                image="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=1706&auto=format&fit=crop"
                date="Oct 05, 2026"
                readTime="5 min read"
            />

            <x-blog-card 
                title="The Ultimate Guide to Selling Your Property Faster"
                excerpt="Staging tips, professional photography requirements, and pricing strategies to attract qualified buyers in a competitive market."
                category="Selling Guide"
                image="https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=1746&auto=format&fit=crop"
                date="Sep 28, 2026"
                readTime="7 min read"
            />

            <x-blog-card 
                title="Navigating Mortgage Rates: What Buyers Need to Know"
                excerpt="Understanding the current lending landscape and strategies to secure the most favorable financing for your next property acquisition."
                category="Buying Guide"
                image="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=1736&auto=format&fit=crop"
                date="Sep 22, 2026"
                readTime="6 min read"
            />

        </div>

        <!-- Pagination Placeholder -->
        <div class="mt-16 flex justify-center">
            <nav class="flex items-center space-x-2" aria-label="Pagination">
                <a href="#" class="p-2 rounded-md text-gray-400 hover:text-[var(--color-primary)] hover:bg-gray-100 transition-colors focus:outline-none">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                </a>
                <a href="#" class="px-4 py-2 rounded-md font-medium text-white bg-[var(--color-primary)] shadow-md">1</a>
                <a href="#" class="px-4 py-2 rounded-md font-medium text-gray-600 bg-white hover:text-[var(--color-primary)] hover:bg-gray-50 transition-colors shadow-sm">2</a>
                <a href="#" class="px-4 py-2 rounded-md font-medium text-gray-600 bg-white hover:text-[var(--color-primary)] hover:bg-gray-50 transition-colors shadow-sm">3</a>
                <span class="px-4 py-2 text-gray-500">...</span>
                <a href="#" class="px-4 py-2 rounded-md font-medium text-gray-600 bg-white hover:text-[var(--color-primary)] hover:bg-gray-50 transition-colors shadow-sm">8</a>
                <a href="#" class="p-2 rounded-md text-gray-400 hover:text-[var(--color-primary)] hover:bg-gray-100 transition-colors focus:outline-none">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                </a>
            </nav>
        </div>

    </div>
</div>
@endsection
