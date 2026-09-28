@extends('layouts.app')

@section('title', $agent->name . ' - Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- HEADER SECTION -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 animate-fade-up-scroll">
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-6">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('agents.index') }}" class="hover:text-[var(--color-primary)] transition-colors">Agents</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">{{ $agent->name }}</span>
        </nav>
        
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 flex flex-col md:flex-row">
            <div class="w-full md:w-1/3 h-64 md:h-auto bg-gray-200 relative">
                <img src="{{ $agent->profile_photo ? Storage::url($agent->profile_photo) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1587&auto=format&fit=crop' }}" class="absolute inset-0 w-full h-full object-cover object-top" alt="{{ $agent->name }}">
            </div>
            <div class="w-full md:w-2/3 p-8 md:p-12 flex flex-col justify-center relative">
                <span class="absolute top-8 right-8 bg-[var(--color-surface-alt)] text-[var(--color-primary)] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider hidden sm:block">
                    {{ $agent->designation ?? 'Real Estate Agent' }}
                </span>
                
                <h1 class="font-heading text-3xl md:text-5xl font-bold text-[var(--color-primary)] mb-2">{{ $agent->name }}</h1>
                <p class="text-lg text-gray-500 mb-4">{{ $agent->designation ?? 'Agent' }} at <a href="#" class="text-[var(--color-accent)] hover:underline font-semibold">{{ $agent->agency ?? 'Independent' }}</a></p>
                
                <div class="flex flex-wrap gap-4 mb-8">
                    @if($agent->city || $agent->country)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ collect([$agent->city, $agent->country])->filter()->join(', ') }}
                    </div>
                    @endif
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        5.0 (0 Reviews)
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $agentProperties->total() }} Active Listings
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    @if($agent->phone)
                    <a href="tel:{{ $agent->phone }}" class="btn-primary px-6 py-2.5 rounded-lg flex items-center shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Call Agent
                    </a>
                    @endif
                    @if($agent->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $agent->whatsapp) }}" target="_blank" class="bg-green-500 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-green-600 transition-colors shadow-md flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        WhatsApp
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- LEFT COLUMN: ABOUT & PROPERTIES -->
            <div class="w-full lg:w-2/3">
                
                <!-- About -->
                @if($agent->bio)
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                    <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-4">About {{ $agent->name }}</h2>
                    <div class="text-gray-600 leading-relaxed space-y-4">
                        {!! nl2br(e($agent->bio)) !!}
                    </div>
                </div>
                @endif

                <!-- Properties -->
                <div class="animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">{{ $agent->name }}'s Listings</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($agentProperties as $property)
                            @php
                                $mainImg = !empty($property->images) ? Storage::url($property->images[0]) : 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1740&auto=format&fit=crop';
                            @endphp
                            <x-property-card 
                                image="{{ $mainImg }}"
                                title="{{ $property->title }}"
                                location="{{ $property->area_locality }}, {{ $property->city }}"
                                type="{{ $property->property_type }}"
                                status="{{ $property->purpose == 'buy' ? 'For Sale' : 'For Rent' }}"
                                price="{{ $property->price }}"
                                bedrooms="{{ $property->bedrooms }}"
                                bathrooms="{{ $property->bathrooms }}"
                                area="{{ $property->area }} sqft"
                                link="{{ route('properties.show', $property->slug ?? $property->id) }}"
                                featured="{{ $property->is_featured ? 'true' : 'false' }}"
                            />
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                <p>No active properties listed by this agent at the moment.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $agentProperties->links() }}
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: CONTACT FORM -->
            <div class="w-full lg:w-1/3">
                <div class="glass-panel rounded-3xl p-8 lg:sticky lg:top-28 animate-fade-up-scroll" style="animation-delay: 0.3s;">
                    <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-6">Contact {{ $agent->name }}</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                        
                        <div>
                            <input type="text" name="name" required placeholder="Your Name" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <input type="email" name="email" required placeholder="Your Email" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <input type="tel" name="phone" placeholder="Your Phone (Optional)" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <textarea name="message" rows="4" required placeholder="I'm interested in..." class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all"></textarea>
                        </div>
                        <button type="submit" class="w-full btn-primary py-3 rounded-lg shadow-md font-semibold mt-2">
                            Send Message
                        </button>
                    </form>
                    
                    <!-- Contact Info -->
                    <div class="mt-8 pt-8 border-t border-gray-100 space-y-4">
                        @if($agent->phone)
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-[var(--color-surface-alt)] flex items-center justify-center text-[var(--color-primary)] shrink-0 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Phone</p>
                                <p class="font-medium text-gray-900">{{ $agent->phone }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($agent->email)
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-[var(--color-surface-alt)] flex items-center justify-center text-[var(--color-primary)] shrink-0 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Email</p>
                                <p class="font-medium text-gray-900">{{ $agent->email }}</p>
                            </div>
                        </div>
                        @endif

                        @if($agent->address)
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-[var(--color-surface-alt)] flex items-center justify-center text-[var(--color-primary)] shrink-0 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Address</p>
                                <p class="font-medium text-gray-900">{{ $agent->address }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Socials -->
                        <div class="flex items-center space-x-3 pt-4">
                            @if($agent->facebook_url)
                            <a href="{{ $agent->facebook_url }}" target="_blank" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:text-[var(--color-primary)] hover:border-[var(--color-primary)] transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            @endif
                            @if($agent->instagram_url)
                            <a href="{{ $agent->instagram_url }}" target="_blank" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:text-[var(--color-primary)] hover:border-[var(--color-primary)] transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            @if($agent->linkedin_url)
                            <a href="{{ $agent->linkedin_url }}" target="_blank" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:text-[var(--color-primary)] hover:border-[var(--color-primary)] transition-colors">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            @endif
                            @if($agent->website_url)
                            <a href="{{ $agent->website_url }}" target="_blank" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:text-[var(--color-primary)] hover:border-[var(--color-primary)] transition-colors">
                                <i class="fas fa-globe"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
