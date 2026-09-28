@extends('layouts.app')

@section('title', 'Aura Premier Group - Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- HEADER SECTION -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 animate-fade-up-scroll">
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-6">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('agencies.index') }}" class="hover:text-[var(--color-primary)] transition-colors">Agencies</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">Aura Premier Group</span>
        </nav>
        
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 p-8 md:p-12 relative">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-8 text-center md:text-left">
                <div class="w-32 h-32 md:w-48 md:h-48 rounded-2xl overflow-hidden bg-white border border-gray-100 shadow-md flex items-center justify-center p-4 flex-shrink-0">
                    <img src="https://images.unsplash.com/photo-1560179707-f14e90ef3623?q=80&w=1500&auto=format&fit=crop" class="max-w-full max-h-full object-contain" alt="Aura Premier Group">
                </div>
                
                <div class="flex-1 flex flex-col justify-center">
                    <span class="bg-[var(--color-surface-alt)] text-[var(--color-primary)] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider self-center md:self-start mb-3">
                        Luxury Estates
                    </span>
                    
                    <h1 class="font-heading text-3xl md:text-5xl font-bold text-[var(--color-primary)] mb-4">Aura Premier Group</h1>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 mb-6">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Beverly Hills, CA
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            14 Agents
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            128 Properties
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                        <button class="btn-primary px-6 py-2.5 rounded-lg flex items-center shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            Contact Agency
                        </button>
                        <button class="btn-secondary px-6 py-2.5 rounded-lg border border-[var(--color-primary)] text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            Website
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- LEFT COLUMN: ABOUT, SERVICES & PROPERTIES -->
            <div class="w-full lg:w-2/3">
                
                <!-- About -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                    <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-4">Agency Overview</h2>
                    <div class="text-gray-600 leading-relaxed space-y-4 mb-8">
                        <p>Aura Premier Group is a boutique luxury real estate brokerage firm dedicated to providing exceptional service and unparalleled results. Headquartered in Beverly Hills, our agency represents some of the most exclusive properties and distinguished clients in the region.</p>
                        <p>Our team of highly curated agents brings decades of combined experience, market expertise, and a global network of buyers and investors. We believe that real estate is not just about transactions, but about building lasting relationships based on trust, discretion, and a shared vision of success.</p>
                    </div>
                    
                    <h3 class="font-heading text-lg font-bold text-[var(--color-primary)] mb-4">Our Services</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 flex items-start">
                            <div class="w-10 h-10 rounded-full bg-[var(--color-surface-alt)] flex items-center justify-center mr-3 text-[var(--color-accent)] flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-[var(--color-primary)] text-sm">Luxury Sales</h4>
                                <p class="text-xs text-gray-500 mt-1">Representing buyers and sellers in high-end transactions.</p>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 flex items-start">
                            <div class="w-10 h-10 rounded-full bg-[var(--color-surface-alt)] flex items-center justify-center mr-3 text-[var(--color-accent)] flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-[var(--color-primary)] text-sm">Commercial Real Estate</h4>
                                <p class="text-xs text-gray-500 mt-1">Investment properties, office spaces, and retail locations.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Our Agents -->
                <div class="mb-10 animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">Our Agents</h2>
                        <a href="{{ route('agents.index') }}" class="text-[var(--color-accent)] font-semibold hover:underline text-sm">View All</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-agent-card 
                            image="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1587&auto=format&fit=crop"
                            name="Michael Sterling"
                            title="Senior Broker"
                            agency="Aura Premier Group"
                            location="Beverly Hills, CA"
                            specialization="Luxury Estates"
                            propertiesCount="24"
                            rating="4.9"
                            reviews="112"
                        />
                        <x-agent-card 
                            image="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=1587&auto=format&fit=crop"
                            name="David Chen"
                            title="Property Specialist"
                            agency="Aura Premier Group"
                            location="San Francisco, CA"
                            specialization="Residential"
                            propertiesCount="31"
                            rating="5.0"
                            reviews="145"
                        />
                    </div>
                </div>

                <!-- Properties -->
                <div class="animate-fade-up-scroll" style="animation-delay: 0.3s;">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">Featured Listings</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-property-card 
                            image="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1740&auto=format&fit=crop"
                            title="Modern Luxury Villa"
                            location="Beverly Hills, CA"
                            type="Villa"
                            status="For Sale"
                            price="$5,200,000"
                            bedrooms="5"
                            bathrooms="6"
                            area="6,500 sqft"
                            :featured="true"
                        />
                        <x-property-card 
                            image="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1740&auto=format&fit=crop"
                            title="Architectural Estate"
                            location="Malibu, CA"
                            type="House"
                            status="For Sale"
                            price="$12,900,000"
                            bedrooms="7"
                            bathrooms="9"
                            area="11,200 sqft"
                            :featured="true"
                        />
                    </div>
                </div>

                <!-- Reviews & Ratings -->
                <x-review-section type="agency" :id="$agency" title="Agency Reviews" />

            </div>

            <!-- RIGHT COLUMN: CONTACT FORM -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 lg:sticky lg:top-28 animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-2">Contact Agency</h2>
                    <p class="text-sm text-gray-500 mb-6">Send an inquiry to Aura Premier Group.</p>
                    
                    <form onsubmit="event.preventDefault(); alert('Message sent successfully!');" class="space-y-4">
                        <div>
                            <label class="sr-only">Your Name</label>
                            <input type="text" required placeholder="Your Name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <label class="sr-only">Email Address</label>
                            <input type="email" required placeholder="Email Address" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <label class="sr-only">Phone Number</label>
                            <input type="tel" placeholder="Phone Number" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <label class="sr-only">Message</label>
                            <textarea rows="4" required placeholder="How can we help you?" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full btn-primary py-3 rounded-lg shadow-md text-lg">
                            Send Message
                        </button>
                    </form>
                    
                    <div class="mt-8 pt-6 border-t border-gray-100 space-y-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-3 text-[var(--color-primary)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            +1 (310) 555-0123
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-3 text-[var(--color-primary)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            contact@aurapremier.com
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-3 text-[var(--color-primary)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            90210 Beverly Hills, CA
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
