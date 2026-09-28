@extends('layouts.app')

@section('title', 'Explore Real Estate Locations | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- PAGE HEADER & SEARCH -->
    <div class="bg-[var(--color-primary)] text-white py-16 lg:py-24 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-30">
            <img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=1844&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)] via-[var(--color-primary)]/80 to-transparent z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-fade-up-scroll">
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-white">Discover Prime Locations</h1>
            <p class="text-gray-300 max-w-2xl mx-auto text-lg mb-10">Find your next home or investment in the most sought-after neighborhoods and thriving communities.</p>
            
            <!-- Global Search Box -->
            <div class="max-w-4xl mx-auto bg-white rounded-2xl p-2 shadow-2xl flex flex-col md:flex-row">
                <div class="flex-1 flex items-center px-4 py-3 md:py-0 border-b md:border-b-0 md:border-r border-gray-100">
                    <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <input type="text" placeholder="Search for City, Area or Community..." class="w-full focus:outline-none text-gray-800 placeholder-gray-400 bg-transparent">
                </div>
                <button class="md:w-32 bg-[var(--color-accent)] hover:bg-yellow-500 text-white font-bold py-4 md:py-4 rounded-xl transition-colors mt-2 md:mt-0 flex-shrink-0">
                    Search
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 space-y-20">
        
        <!-- POPULAR CITIES -->
        <section>
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="font-heading text-3xl font-bold text-[var(--color-primary)] mb-2">Popular Cities</h2>
                    <p class="text-gray-500">Explore real estate in major metropolitan areas.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-city-card 
                    image="https://images.unsplash.com/photo-1546412414-e1885259563a?q=80&w=1587&auto=format&fit=crop"
                    name="Dubai"
                    propertiesCount="1,245"
                    projectsCount="86"
                />
                <x-city-card 
                    image="https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?q=80&w=1740&auto=format&fit=crop"
                    name="London"
                    propertiesCount="956"
                    projectsCount="42"
                />
                <x-city-card 
                    image="https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?q=80&w=1740&auto=format&fit=crop"
                    name="New York"
                    propertiesCount="2,108"
                    projectsCount="115"
                />
                <x-city-card 
                    image="https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?q=80&w=1740&auto=format&fit=crop"
                    name="Sydney"
                    propertiesCount="642"
                    projectsCount="28"
                />
            </div>
        </section>

        <!-- TOP AREAS & COMMUNITIES -->
        <section class="animate-fade-up-scroll" style="animation-delay: 0.1s;">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="font-heading text-3xl font-bold text-[var(--color-primary)] mb-2">Trending Areas</h2>
                    <p class="text-gray-500">Discover highly sought-after neighborhoods and societies.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-area-card 
                    name="Downtown"
                    city="Dubai"
                    image="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=1740&auto=format&fit=crop"
                    propertiesCount="324"
                />
                <x-area-card 
                    name="Mayfair"
                    city="London"
                    image="https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?q=80&w=1740&auto=format&fit=crop"
                    propertiesCount="156"
                />
                <x-area-card 
                    name="Manhattan"
                    city="New York"
                    image="https://images.unsplash.com/photo-1485871981521-5b1fd3805eee?q=80&w=1740&auto=format&fit=crop"
                    propertiesCount="845"
                />
                <x-area-card 
                    name="Palm Jumeirah"
                    city="Dubai"
                    image="https://images.unsplash.com/photo-1574362848149-11496d93a7c7?q=80&w=1684&auto=format&fit=crop"
                    propertiesCount="218"
                />
                <x-area-card 
                    name="Beverly Hills"
                    city="Los Angeles"
                    image="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1740&auto=format&fit=crop"
                    propertiesCount="142"
                />
                <x-area-card 
                    name="Bondi Beach"
                    city="Sydney"
                    image="https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?q=80&w=1740&auto=format&fit=crop"
                    propertiesCount="86"
                />
            </div>
        </section>

        <!-- CALL TO ACTION -->
        <section class="bg-[var(--color-primary)] rounded-3xl p-10 md:p-16 text-center text-white relative overflow-hidden animate-fade-up-scroll">
            <div class="absolute top-0 left-0 w-full h-full bg-[var(--color-accent)] opacity-10 rounded-full blur-3xl transform translate-y-1/2"></div>
            <div class="relative z-10 max-w-3xl mx-auto">
                <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4 text-white">Can't decide where to look?</h2>
                <p class="text-gray-300 text-lg mb-8">Our expert real estate agents can help you find the perfect location based on your budget, lifestyle, and investment goals.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('agents.index') }}" class="btn-primary bg-[var(--color-accent)] hover:bg-yellow-500 text-[var(--color-primary)] px-8 py-3 rounded-lg font-bold">
                        Speak to an Agent
                    </a>
                    <a href="{{ route('properties.index') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur border border-white/50 px-8 py-3 rounded-lg font-bold transition-colors">
                        Browse All Properties
                    </a>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
