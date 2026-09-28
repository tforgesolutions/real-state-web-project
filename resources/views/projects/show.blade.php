@extends('layouts.app')

@section('title', ($project->title ?? 'Project Details') . ' - Projects | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- PROJECT HERO -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 animate-fade-up-scroll">
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-6">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('projects.index') }}" class="hover:text-[var(--color-primary)] transition-colors">Projects</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">{{ $project->title }}</span>
        </nav>
        
        <div class="relative w-full h-[400px] md:h-[500px] rounded-3xl overflow-hidden shadow-xl">
            @php
                $mainImg = !empty($project->images) ? Storage::url($project->images[0]) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1740&auto=format&fit=crop';
            @endphp
            <img src="{{ $mainImg }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $project->title }}">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12 text-white">
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="bg-[var(--color-accent)] text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                        {{ $project->status ?? 'Ongoing' }}
                    </span>
                    <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md border border-white/30">
                        {{ $project->project_type ?? 'Mixed-use' }}
                    </span>
                </div>
                
                <h1 class="font-heading text-4xl md:text-6xl font-bold mb-2 drop-shadow-lg">{{ $project->title }}</h1>
                <p class="text-lg md:text-xl text-gray-200 flex items-center mb-6 drop-shadow-md">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $project->location ?? 'Downtown, New York' }}
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <button class="bg-[var(--color-primary)] hover:bg-[var(--color-primary-light)] text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                        Explore Properties
                    </button>
                    <button class="bg-white/10 hover:bg-white/20 backdrop-blur border border-white/50 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                        Download Brochure
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- LEFT COLUMN: DETAILS -->
            <div class="w-full lg:w-2/3 space-y-12">
                
                <!-- Overview -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                    <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Project Overview</h2>
                    <div class="text-gray-600 leading-relaxed space-y-4 font-light">
                        {!! $project->description ?? 'Aura Towers is a state-of-the-art mixed-use development set to redefine the city skyline.' !!}
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-8 border-t border-gray-100">
                        <div>
                            <span class="block text-sm text-gray-500 mb-1 uppercase font-semibold">Starting Price</span>
                            <strong class="text-xl text-[var(--color-primary)]">${{ number_format($project->starting_price ?? 850000) }}</strong>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-500 mb-1 uppercase font-semibold">Project Status</span>
                            <strong class="text-lg text-gray-900">{{ $project->status ?? 'Ongoing' }}</strong>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-500 mb-1 uppercase font-semibold">Total Units</span>
                            <strong class="text-lg text-gray-900">{{ $project->total_units ?? 320 }}</strong>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-500 mb-1 uppercase font-semibold">Completion</span>
                            <strong class="text-lg text-gray-900">{{ $project->completion_date ? $project->completion_date->format('M Y') : 'Q4 2028' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Available Property Types -->
                <div class="animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Available Units</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Unit Type Card -->
                        <div class="flex flex-col sm:flex-row bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
                            <div class="w-full sm:w-2/5 h-48 sm:h-auto bg-gray-200 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=1706&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="font-bold text-lg text-[var(--color-primary)] mb-1">Luxury Apartments</h3>
                                <p class="text-xs text-gray-500 mb-3">1, 2 & 3 Bedrooms</p>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">Spacious open-plan layouts with floor-to-ceiling windows and premium finishes.</p>
                                <div class="mt-auto flex justify-between items-end">
                                    <div>
                                        <span class="block text-xs text-gray-500">From</span>
                                        <strong class="text-[var(--color-accent)]">$850,000</strong>
                                    </div>
                                    <button class="text-sm font-semibold text-[var(--color-primary)] hover:underline">View Options</button>
                                </div>
                            </div>
                        </div>

                        <!-- Unit Type Card -->
                        <div class="flex flex-col sm:flex-row bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
                            <div class="w-full sm:w-2/5 h-48 sm:h-auto bg-gray-200 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1740&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="font-bold text-lg text-[var(--color-primary)] mb-1">Sky Penthouses</h3>
                                <p class="text-xs text-gray-500 mb-3">4 & 5 Bedrooms</p>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">Exclusive top-floor residences offering unparalleled city views and private terraces.</p>
                                <div class="mt-auto flex justify-between items-end">
                                    <div>
                                        <span class="block text-xs text-gray-500">From</span>
                                        <strong class="text-[var(--color-accent)]">$3,200,000</strong>
                                    </div>
                                    <button class="text-sm font-semibold text-[var(--color-primary)] hover:underline">View Options</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Amenities -->
                @if(!empty($project->amenities) && count($project->amenities) > 0)
                <div class="animate-fade-up-scroll" style="animation-delay: 0.3s;">
                    <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Project Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($project->amenities as $amenity)
                        <div class="bg-white border border-gray-100 rounded-xl p-4 text-center hover:border-[var(--color-accent)] transition-colors group">
                            <div class="w-12 h-12 mx-auto bg-[var(--color-surface-alt)] text-[var(--color-primary)] rounded-full flex items-center justify-center mb-3 group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">{{ $amenity }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Gallery -->
                @if(!empty($project->images) && count($project->images) > 0)
                <div class="animate-fade-up-scroll" style="animation-delay: 0.4s;">
                    <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Project Gallery</h2>
                    <x-property-gallery :images="$project->images" />
                </div>
                @endif
            </div>

            <!-- RIGHT COLUMN: DEVELOPER & CONTACT -->
            <div class="w-full lg:w-1/3 space-y-8">
                
                <!-- Inquiry Form -->
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 lg:sticky lg:top-28 animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-2">Register Interest</h3>
                    <p class="text-sm text-gray-500 mb-6">Receive floor plans, pricing, and project updates.</p>
                    
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                        @csrf
                        @if(isset($project))
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                        @endif
                        <input type="hidden" name="inquiry_type" value="Project Inquiry">
                        <div>
                            <label class="sr-only">Your Name</label>
                            <input type="text" name="name" required placeholder="Your Name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <label class="sr-only">Email Address</label>
                            <input type="email" name="email" required placeholder="Email Address" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <label class="sr-only">Phone Number</label>
                            <input type="tel" name="phone" required placeholder="Phone Number" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <label class="sr-only">Message</label>
                            <textarea name="message" rows="3" required placeholder="I am interested in this project..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full btn-primary py-3 rounded-lg shadow-md text-lg">
                            Send Inquiry
                        </button>
                    </form>
                </div>

                <!-- Developer Info -->
                <div class="bg-[var(--color-surface-alt)] rounded-3xl p-8 border border-gray-200 animate-fade-up-scroll" style="animation-delay: 0.3s;">
                    <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-4">Developed By</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center p-2">
                            <span class="font-bold text-[var(--color-primary)] text-sm text-center">DEV</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-900">{{ $project->developer ?? 'Aura Developments' }}</h4>
                        </div>
                    </div>
                    <button class="w-full text-center py-2.5 border border-[var(--color-primary)] text-[var(--color-primary)] rounded-lg text-sm font-medium hover:bg-[var(--color-primary)] hover:text-white transition-colors">
                        View Developer Profile
                    </button>
                </div>

                <!-- Location Map Placeholder -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 h-[250px] relative animate-fade-up-scroll" style="animation-delay: 0.4s;">
                    <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1748&auto=format&fit=crop" class="w-full h-full object-cover opacity-60">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-bold text-lg drop-shadow-md">Project Location</h4>
                        <p class="text-sm text-gray-200 drop-shadow-md mb-2">{{ $project->location ?? 'Downtown, New York' }}</p>
                        <button class="w-full bg-white/90 text-[var(--color-primary)] py-2 rounded-lg text-sm font-bold shadow hover:bg-white transition-colors">
                            View on Map
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
