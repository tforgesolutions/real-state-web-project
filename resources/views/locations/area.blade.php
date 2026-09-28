@extends('layouts.app')

@section('title', ucfirst($area) . ', ' . ucfirst($city) . ' Real Estate | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- HEADER -->
    <div class="bg-[var(--color-primary)] text-white py-12 lg:py-16 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1529141042784-3c66f5bc2f21?q=80&w=1661&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[var(--color-primary)] to-transparent z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 animate-fade-up-scroll">
            <nav class="flex items-center text-sm text-gray-300 space-x-2 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('locations.index') }}" class="hover:text-white transition-colors">Locations</a>
                <span>/</span>
                <a href="{{ route('locations.city', $city) }}" class="hover:text-white transition-colors">{{ ucfirst($city) }}</a>
                <span>/</span>
                <span class="text-white font-medium">{{ ucfirst($area) }}</span>
            </nav>
            
            <h1 class="font-heading text-4xl md:text-5xl font-bold mb-4">{{ ucfirst($area) }}</h1>
            <p class="text-gray-300 max-w-2xl text-lg mb-8">Discover the vibrant community, prime real estate, and exclusive lifestyle of {{ ucfirst($area) }}, {{ ucfirst($city) }}.</p>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('properties.index') }}" class="btn-primary bg-[var(--color-accent)] hover:bg-yellow-500 text-[var(--color-primary)] px-6 py-2.5 rounded-lg font-bold shadow-md">
                    Buy in {{ ucfirst($area) }}
                </a>
                <a href="{{ route('properties.index', ['layout' => 'list']) }}" class="bg-white/10 hover:bg-white/20 backdrop-blur border border-white/50 px-6 py-2.5 rounded-lg font-bold transition-colors shadow-md">
                    Rent in {{ ucfirst($area) }}
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- LEFT COLUMN: CONTENT -->
            <div class="w-full lg:w-2/3 space-y-12">
                
                <!-- About Area -->
                <section class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                    <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-4">About {{ ucfirst($area) }}</h2>
                    <div class="text-gray-600 leading-relaxed space-y-4 font-light">
                        <p>{{ ucfirst($area) }} is recognized as one of the most prestigious and highly sought-after neighborhoods in {{ ucfirst($city) }}. Known for its beautifully landscaped streets, upscale dining, and premium shopping, it offers a sophisticated lifestyle for residents and investors alike.</p>
                        <p>The real estate landscape here features a mix of modern luxury apartments, sprawling historic estates, and secure gated communities. With excellent connectivity to the rest of the city and world-class amenities within walking distance, it remains a top choice for discerning buyers.</p>
                    </div>
                </section>

                <!-- Properties Grid -->
                <section class="animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">Properties in {{ ucfirst($area) }}</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <x-property-card 
                            image="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1740&auto=format&fit=crop"
                            title="Exclusive Residence"
                            location="{{ ucfirst($area) }}, {{ ucfirst($city) }}"
                            type="House"
                            status="For Sale"
                            price="$3,450,000"
                            bedrooms="4"
                            bathrooms="5"
                            area="4,200 sqft"
                            :featured="true"
                        />
                        <x-property-card 
                            image="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1740&auto=format&fit=crop"
                            title="Luxury Apartment"
                            location="{{ ucfirst($area) }}, {{ ucfirst($city) }}"
                            type="Apartment"
                            status="For Rent"
                            price="$8,500/mo"
                            bedrooms="2"
                            bathrooms="2"
                            area="1,800 sqft"
                            :featured="false"
                        />
                    </div>
                    
                    <div class="mt-8 text-center">
                        <a href="{{ route('properties.index') }}" class="inline-block bg-[var(--color-primary)] text-white px-8 py-3 rounded-lg font-bold hover:bg-[var(--color-primary-light)] transition-colors shadow-md">
                            View All 324 Properties
                        </a>
                    </div>
                </section>

            </div>

            <!-- RIGHT COLUMN: SIDEBAR -->
            <div class="w-full lg:w-1/3 space-y-8">
                
                <!-- Map Placeholder -->
                <div class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                    <div class="rounded-2xl overflow-hidden h-[250px] relative">
                        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1748&auto=format&fit=crop" class="w-full h-full object-cover opacity-70">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="w-12 h-12 bg-[var(--color-accent)] rounded-full flex items-center justify-center shadow-lg border-4 border-white animate-bounce">
                                <svg class="w-6 h-6 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <button class="w-full bg-white/90 text-[var(--color-primary)] py-2 rounded-lg text-sm font-bold shadow hover:bg-white transition-colors">
                                View Interactive Map
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Area Quick Links -->
                <div class="bg-gray-50 rounded-3xl p-6 border border-gray-200 animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <h3 class="font-heading text-lg font-bold text-[var(--color-primary)] mb-4">Explore Nearby</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="flex items-center text-gray-600 hover:text-[var(--color-accent)] transition-colors group">
                                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-[var(--color-accent)] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                West {{ ucfirst($area) }}
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center text-gray-600 hover:text-[var(--color-accent)] transition-colors group">
                                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-[var(--color-accent)] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                {{ ucfirst($area) }} Heights
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center text-gray-600 hover:text-[var(--color-accent)] transition-colors group">
                                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-[var(--color-accent)] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                Central {{ ucfirst($city) }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Area Specialist -->
                <div class="bg-[var(--color-primary)] rounded-3xl p-8 text-white shadow-xl animate-fade-up-scroll" style="animation-delay: 0.3s;">
                    <h3 class="font-heading text-xl font-bold mb-2">Speak to a Specialist</h3>
                    <p class="text-sm text-gray-300 mb-6">Our agents know {{ ucfirst($area) }} inside and out. Let us help you find the perfect property.</p>
                    <a href="{{ route('agents.index') }}" class="block w-full bg-[var(--color-accent)] hover:bg-yellow-500 text-[var(--color-primary)] py-3 rounded-lg font-bold text-center transition-colors">
                        Find an Agent
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
