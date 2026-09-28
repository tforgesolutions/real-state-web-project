@extends('layouts.app')

@section('title', ucfirst($city) . ' Real Estate | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- CITY HERO -->
    <div class="relative w-full h-[350px] md:h-[450px]">
        <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=1740&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover" alt="{{ ucfirst($city) }}">
        <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)] via-black/40 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 right-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 z-10 animate-fade-up-scroll">
            <nav class="flex items-center text-sm text-gray-300 space-x-2 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('locations.index') }}" class="hover:text-white transition-colors">Locations</a>
                <span>/</span>
                <span class="text-white font-medium">{{ ucfirst($city) }}</span>
            </nav>
            
            <h1 class="font-heading text-4xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">Real Estate in {{ ucfirst($city) }}</h1>
            <p class="text-lg md:text-xl text-gray-200 max-w-2xl drop-shadow-md mb-8">
                Explore luxury apartments, exclusive villas, and prime commercial spaces in one of the world's most dynamic cities.
            </p>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('properties.index') }}" class="btn-primary bg-[var(--color-accent)] hover:bg-yellow-500 text-[var(--color-primary)] px-8 py-3 rounded-lg font-bold shadow-lg">
                    Browse All Properties
                </a>
                <a href="{{ route('projects.index') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur border border-white/50 text-white px-8 py-3 rounded-lg font-bold transition-colors shadow-lg">
                    View New Projects
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 space-y-16">
        
        <!-- POPULAR AREAS -->
        <section class="animate-fade-up-scroll" style="animation-delay: 0.1s;">
            <div class="flex justify-between items-center mb-8">
                <h2 class="font-heading text-2xl md:text-3xl font-bold text-[var(--color-primary)]">Popular Areas in {{ ucfirst($city) }}</h2>
                <a href="#" class="text-[var(--color-accent)] font-semibold hover:underline">View All Areas</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-area-card name="Downtown" city="{{ ucfirst($city) }}" image="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=1740&auto=format&fit=crop" propertiesCount="324" />
                <x-area-card name="Marina Bay" city="{{ ucfirst($city) }}" image="https://images.unsplash.com/photo-1574362848149-11496d93a7c7?q=80&w=1684&auto=format&fit=crop" propertiesCount="156" />
                <x-area-card name="Business District" city="{{ ucfirst($city) }}" image="https://images.unsplash.com/photo-1485871981521-5b1fd3805eee?q=80&w=1740&auto=format&fit=crop" propertiesCount="218" />
            </div>
        </section>

        <!-- PROPERTY TYPES QUICK LINKS -->
        <section class="animate-fade-up-scroll" style="animation-delay: 0.2s;">
            <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Browse by Type</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <a href="{{ route('properties.index') }}" class="bg-white border border-gray-100 rounded-2xl p-6 text-center hover:border-[var(--color-accent)] hover:shadow-md transition-all group">
                    <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3 group-hover:bg-[var(--color-surface-alt)] group-hover:text-[var(--color-accent)] transition-colors text-gray-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="block font-bold text-gray-700">Apartments</span>
                </a>
                <a href="{{ route('properties.index') }}" class="bg-white border border-gray-100 rounded-2xl p-6 text-center hover:border-[var(--color-accent)] hover:shadow-md transition-all group">
                    <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3 group-hover:bg-[var(--color-surface-alt)] group-hover:text-[var(--color-accent)] transition-colors text-gray-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <span class="block font-bold text-gray-700">Houses</span>
                </a>
                <a href="{{ route('properties.index') }}" class="bg-white border border-gray-100 rounded-2xl p-6 text-center hover:border-[var(--color-accent)] hover:shadow-md transition-all group">
                    <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3 group-hover:bg-[var(--color-surface-alt)] group-hover:text-[var(--color-accent)] transition-colors text-gray-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21v-4m22 4v-4m-3-11.2a2 2 0 00-1.5-.8h-11a2 2 0 00-1.5.8L2 12v5h20v-5l-1.5-6.2zM9 17h6M7 7h10"></path></svg>
                    </div>
                    <span class="block font-bold text-gray-700">Villas</span>
                </a>
                <a href="{{ route('properties.index') }}" class="bg-white border border-gray-100 rounded-2xl p-6 text-center hover:border-[var(--color-accent)] hover:shadow-md transition-all group">
                    <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3 group-hover:bg-[var(--color-surface-alt)] group-hover:text-[var(--color-accent)] transition-colors text-gray-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="block font-bold text-gray-700">Commercial</span>
                </a>
                <a href="{{ route('properties.index') }}" class="bg-white border border-gray-100 rounded-2xl p-6 text-center hover:border-[var(--color-accent)] hover:shadow-md transition-all group">
                    <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3 group-hover:bg-[var(--color-surface-alt)] group-hover:text-[var(--color-accent)] transition-colors text-gray-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="block font-bold text-gray-700">Plots</span>
                </a>
            </div>
        </section>

        <!-- FEATURED PROPERTIES -->
        <section class="animate-fade-up-scroll" style="animation-delay: 0.3s;">
            <div class="flex justify-between items-center mb-8">
                <h2 class="font-heading text-2xl md:text-3xl font-bold text-[var(--color-primary)]">Featured in {{ ucfirst($city) }}</h2>
                <a href="{{ route('properties.index') }}" class="text-[var(--color-accent)] font-semibold hover:underline">View All</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-property-card 
                    image="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1744&auto=format&fit=crop"
                    title="Modern Luxury Villa"
                    location="{{ ucfirst($city) }}"
                    type="Villa"
                    status="For Sale"
                    price="$5,200,000"
                    bedrooms="5"
                    bathrooms="6"
                    area="6,500 sqft"
                    :featured="true"
                />
                <x-property-card 
                    image="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1740&auto=format&fit=crop"
                    title="Downtown Penthouse"
                    location="{{ ucfirst($city) }}"
                    type="Apartment"
                    status="For Rent"
                    price="$12,000/mo"
                    bedrooms="3"
                    bathrooms="4"
                    area="3,200 sqft"
                    :featured="true"
                />
                <x-property-card 
                    image="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1740&auto=format&fit=crop"
                    title="Seaside Estate"
                    location="{{ ucfirst($city) }}"
                    type="House"
                    status="For Sale"
                    price="$8,900,000"
                    bedrooms="6"
                    bathrooms="7"
                    area="9,800 sqft"
                    :featured="false"
                />
            </div>
        </section>

    </div>
</div>
@endsection
