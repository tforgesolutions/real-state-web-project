@extends('layouts.app')

@section('title', 'About Us | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- HERO SECTION -->
    <div class="bg-[var(--color-primary)] text-white py-20 lg:py-28 relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1770&auto=format&fit=crop" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)] to-[var(--color-primary)]/80"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-fade-up-scroll">
            <nav class="flex items-center justify-center text-sm text-gray-400 space-x-2 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <span class="text-white font-medium">About Us</span>
            </nav>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-7xl font-bold mb-6 text-white">Redefining the Search for Your Perfect Home</h1>
            <p class="text-gray-300 max-w-2xl mx-auto text-lg md:text-xl mb-10 leading-relaxed">
                Aura is a modern digital platform designed to make property discovery simpler, clearer, and more convenient. Explore properties, projects, agents, and locations all in one elegant place.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('properties.index') }}" class="btn-primary py-4 px-10 rounded-xl font-bold shadow-lg text-lg flex items-center justify-center transition-all">
                    Explore Properties
                </a>
                <a href="{{ route('properties.create') }}" class="bg-transparent border border-white hover:bg-white hover:text-[var(--color-primary)] py-4 px-10 rounded-xl font-bold transition-colors duration-300 text-lg flex items-center justify-center">
                    List Your Property
                </a>
            </div>
        </div>
    </div>

    <!-- PLATFORM INTRODUCTION (SPLIT LAYOUT) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="flex flex-col lg:flex-row gap-16 items-center">
            <div class="w-full lg:w-1/2 animate-fade-up-scroll">
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-[var(--color-primary)] mb-6">A Clean and Convenient Digital Property Experience</h2>
                <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                    We believe that finding a home or commercial space shouldn't be a fragmented, confusing process. We built Aura to connect users with relevant property opportunities through an intuitive, beautifully designed interface.
                </p>
                <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                    Whether you are searching for a new rental, buying your first home, or exploring high-end investment projects, our platform brings together the data, the visuals, and the professionals you need to make informed decisions.
                </p>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center text-[var(--color-primary)] font-bold">
                        <svg class="w-5 h-5 text-[var(--color-accent)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Advanced Property Search
                    </div>
                    <div class="flex items-center text-[var(--color-primary)] font-bold">
                        <svg class="w-5 h-5 text-[var(--color-accent)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Property Comparison
                    </div>
                    <div class="flex items-center text-[var(--color-primary)] font-bold">
                        <svg class="w-5 h-5 text-[var(--color-accent)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Projects & Developments
                    </div>
                    <div class="flex items-center text-[var(--color-primary)] font-bold">
                        <svg class="w-5 h-5 text-[var(--color-accent)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Trusted Agents & Agencies
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/2 relative animate-fade-up-scroll" style="animation-delay: 0.2s;">
                <div class="absolute inset-0 bg-[var(--color-accent)] rounded-3xl transform translate-x-4 translate-y-4 opacity-20"></div>
                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1775&auto=format&fit=crop" class="relative z-10 rounded-3xl shadow-2xl object-cover h-[500px] w-full" alt="Modern Architecture">
            </div>
        </div>
    </div>

    <!-- MISSION & VISION -->
    <div class="bg-gray-50 py-20 border-t border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Mission -->
                <div class="bg-white p-10 lg:p-12 rounded-3xl shadow-xl border border-gray-100 animate-fade-up-scroll">
                    <div class="w-16 h-16 bg-[var(--color-primary)] rounded-2xl flex items-center justify-center text-[var(--color-accent)] mb-8">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"></path></svg>
                    </div>
                    <h3 class="font-heading text-3xl font-bold text-[var(--color-primary)] mb-6">Our Mission</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To make property discovery simpler, clearer, and more convenient for users. We strive to remove the friction from the real estate process by providing accurate listings, powerful comparison tools, and seamless connections to industry professionals.
                    </p>
                </div>
                
                <!-- Vision -->
                <div class="bg-[var(--color-primary)] p-10 lg:p-12 rounded-3xl shadow-xl text-white relative overflow-hidden animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-[var(--color-accent)] rounded-2xl flex items-center justify-center text-[var(--color-primary)] mb-8">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <h3 class="font-heading text-3xl font-bold mb-6 text-white">Our Vision</h3>
                        <p class="text-gray-300 text-lg leading-relaxed">
                            To create a modern, unified digital platform where people can discover properties, exclusive projects, and vetted property professionals all in one place, setting a new standard for real estate accessibility and design.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CORE VALUES -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 text-center">
        <h2 class="font-heading text-3xl md:text-5xl font-bold text-[var(--color-primary)] mb-4 animate-fade-up-scroll">Our Core Values</h2>
        <p class="text-gray-500 max-w-2xl mx-auto text-lg mb-16 animate-fade-up-scroll">The principles that guide our platform design and functionality.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Value 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 group animate-fade-up-scroll">
                <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-[var(--color-accent)] mb-6 group-hover:scale-110 group-hover:bg-[var(--color-primary)] transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <h4 class="font-bold text-xl text-[var(--color-primary)] mb-3">Transparency</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Providing clear, structured property data without hidden information, allowing users to make decisions confidently.</p>
            </div>
            <!-- Value 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 group animate-fade-up-scroll" style="animation-delay: 0.1s;">
                <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-[var(--color-accent)] mb-6 group-hover:scale-110 group-hover:bg-[var(--color-primary)] transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                </div>
                <h4 class="font-bold text-xl text-[var(--color-primary)] mb-3">User Experience</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Designing beautiful, intuitive interfaces that make browsing real estate a joy rather than a chore.</p>
            </div>
            <!-- Value 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 group animate-fade-up-scroll" style="animation-delay: 0.2s;">
                <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-[var(--color-accent)] mb-6 group-hover:scale-110 group-hover:bg-[var(--color-primary)] transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h4 class="font-bold text-xl text-[var(--color-primary)] mb-3">Simplicity</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Removing unnecessary complexity from the search process and streamlining connections to agents and owners.</p>
            </div>
            <!-- Value 4 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 group animate-fade-up-scroll" style="animation-delay: 0.3s;">
                <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-[var(--color-accent)] mb-6 group-hover:scale-110 group-hover:bg-[var(--color-primary)] transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h4 class="font-bold text-xl text-[var(--color-primary)] mb-3">Trust</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Fostering reliable relationships by only highlighting verified projects and trusted property professionals.</p>
            </div>
            <!-- Value 5 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 group animate-fade-up-scroll" style="animation-delay: 0.4s;">
                <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-[var(--color-accent)] mb-6 group-hover:scale-110 group-hover:bg-[var(--color-primary)] transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                </div>
                <h4 class="font-bold text-xl text-[var(--color-primary)] mb-3">Accessibility</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Ensuring our platform works seamlessly across all devices, allowing users to search properties anytime, anywhere.</p>
            </div>
            <!-- Value 6 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 group animate-fade-up-scroll" style="animation-delay: 0.5s;">
                <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-[var(--color-accent)] mb-6 group-hover:scale-110 group-hover:bg-[var(--color-primary)] transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                </div>
                <h4 class="font-bold text-xl text-[var(--color-primary)] mb-3">Innovation</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Continually refining our features, from robust comparison tools to interactive discovery maps.</p>
            </div>
        </div>
    </div>

    <!-- HOW IT WORKS -->
    <div class="bg-white py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-fade-up-scroll">
                <h2 class="font-heading text-3xl md:text-5xl font-bold text-[var(--color-primary)] mb-4">How It Works</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">A straightforward process to connect you with the perfect property.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <!-- Connecting Line (Desktop only) -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-100 -z-10 transform -translate-y-1/2"></div>
                
                <!-- Step 1 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center relative z-10 animate-fade-up-scroll">
                    <div class="w-12 h-12 bg-[var(--color-accent)] text-[var(--color-primary)] rounded-full flex items-center justify-center font-bold text-xl mx-auto mb-6 shadow-md">01</div>
                    <h4 class="font-bold text-lg text-[var(--color-primary)] mb-3">Search</h4>
                    <p class="text-gray-500 text-sm">Explore properties using location, type, price and advanced filters.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center relative z-10 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                    <div class="w-12 h-12 bg-[var(--color-accent)] text-[var(--color-primary)] rounded-full flex items-center justify-center font-bold text-xl mx-auto mb-6 shadow-md">02</div>
                    <h4 class="font-bold text-lg text-[var(--color-primary)] mb-3">Discover</h4>
                    <p class="text-gray-500 text-sm">Open property details, compare options side-by-side, and explore related listings.</p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center relative z-10 animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <div class="w-12 h-12 bg-[var(--color-accent)] text-[var(--color-primary)] rounded-full flex items-center justify-center font-bold text-xl mx-auto mb-6 shadow-md">03</div>
                    <h4 class="font-bold text-lg text-[var(--color-primary)] mb-3">Connect</h4>
                    <p class="text-gray-500 text-sm">Send inquiries or directly contact the relevant agent or property owner.</p>
                </div>

                <!-- Step 4 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center relative z-10 animate-fade-up-scroll" style="animation-delay: 0.3s;">
                    <div class="w-12 h-12 bg-[var(--color-accent)] text-[var(--color-primary)] rounded-full flex items-center justify-center font-bold text-xl mx-auto mb-6 shadow-md">04</div>
                    <h4 class="font-bold text-lg text-[var(--color-primary)] mb-3">Decide</h4>
                    <p class="text-gray-500 text-sm">Review information, attend viewings, and continue with your real estate journey.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- USER JOURNEY SECTION -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="text-center mb-16 animate-fade-up-scroll">
            <h2 class="font-heading text-3xl md:text-5xl font-bold text-[var(--color-primary)] mb-4">Choose Your Journey</h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg">Tailored experiences depending on your real estate goals.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Buy Journey -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-lg border border-gray-100 group animate-fade-up-scroll">
                <div class="h-48 overflow-hidden relative">
                    <div class="absolute inset-0 bg-black/20 z-10 group-hover:bg-transparent transition-colors duration-500"></div>
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1740&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="p-8">
                    <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-4">Buy a Property</h3>
                    <div class="flex items-center text-sm font-bold text-[var(--color-accent)] mb-6 uppercase tracking-wider space-x-2">
                        <span>Search</span>
                        <span>→</span>
                        <span>Compare</span>
                        <span>→</span>
                        <span>Contact</span>
                    </div>
                    <p class="text-gray-600 mb-6">Discover your dream home with our advanced filtering and property comparison tools.</p>
                    <a href="{{ route('properties.index') }}" class="inline-flex items-center text-[var(--color-primary)] font-bold hover:text-[var(--color-accent)] transition-colors">
                        Start Buying <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Rent Journey -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-lg border border-gray-100 group animate-fade-up-scroll" style="animation-delay: 0.1s;">
                <div class="h-48 overflow-hidden relative">
                    <div class="absolute inset-0 bg-black/20 z-10 group-hover:bg-transparent transition-colors duration-500"></div>
                    <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1775&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="p-8">
                    <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-4">Rent a Property</h3>
                    <div class="flex items-center text-sm font-bold text-[var(--color-accent)] mb-6 uppercase tracking-wider space-x-2">
                        <span>Search</span>
                        <span>→</span>
                        <span>Review</span>
                        <span>→</span>
                        <span>Contact</span>
                    </div>
                    <p class="text-gray-600 mb-6">Explore rental listings, view comprehensive amenities, and securely contact leasing agents.</p>
                    <a href="{{ route('properties.index', ['layout' => 'list']) }}" class="inline-flex items-center text-[var(--color-primary)] font-bold hover:text-[var(--color-accent)] transition-colors">
                        Start Renting <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- List Journey -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-lg border border-gray-100 group animate-fade-up-scroll" style="animation-delay: 0.2s;">
                <div class="h-48 overflow-hidden relative">
                    <div class="absolute inset-0 bg-black/20 z-10 group-hover:bg-transparent transition-colors duration-500"></div>
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=1746&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="p-8">
                    <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-4">List a Property</h3>
                    <div class="flex items-center text-sm font-bold text-[var(--color-accent)] mb-6 uppercase tracking-wider space-x-2">
                        <span>Details</span>
                        <span>→</span>
                        <span>Media</span>
                        <span>→</span>
                        <span>Submit</span>
                    </div>
                    <p class="text-gray-600 mb-6">Use our elegant submission wizard to list your property and reach thousands of prospective buyers.</p>
                    <a href="{{ route('properties.create') }}" class="inline-flex items-center text-[var(--color-primary)] font-bold hover:text-[var(--color-accent)] transition-colors">
                        Start Listing <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- PLATFORM FEATURES (Quick Links) -->
    <div class="bg-gray-50 py-20 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 animate-fade-up-scroll">
                <h2 class="font-heading text-3xl font-bold text-[var(--color-primary)] mb-4">Explore Platform Features</h2>
            </div>
            
            <div class="flex flex-wrap justify-center gap-4 animate-fade-up-scroll">
                <a href="{{ route('properties.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-full text-gray-600 font-medium hover:border-[var(--color-accent)] hover:text-[var(--color-primary)] shadow-sm hover:shadow transition-all">Property Listings</a>
                <a href="{{ route('compare.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-full text-gray-600 font-medium hover:border-[var(--color-accent)] hover:text-[var(--color-primary)] shadow-sm hover:shadow transition-all">Property Comparison</a>
                <a href="{{ route('favorites.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-full text-gray-600 font-medium hover:border-[var(--color-accent)] hover:text-[var(--color-primary)] shadow-sm hover:shadow transition-all">Saved Properties</a>
                <a href="{{ route('projects.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-full text-gray-600 font-medium hover:border-[var(--color-accent)] hover:text-[var(--color-primary)] shadow-sm hover:shadow transition-all">Projects & Developments</a>
                <a href="{{ route('agents.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-full text-gray-600 font-medium hover:border-[var(--color-accent)] hover:text-[var(--color-primary)] shadow-sm hover:shadow transition-all">Agents & Agencies</a>
                <a href="{{ route('locations.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-full text-gray-600 font-medium hover:border-[var(--color-accent)] hover:text-[var(--color-primary)] shadow-sm hover:shadow transition-all">Locations Directory</a>
                <a href="{{ route('blog.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-full text-gray-600 font-medium hover:border-[var(--color-accent)] hover:text-[var(--color-primary)] shadow-sm hover:shadow transition-all">News & Insights</a>
                <a href="{{ route('contact.index') }}" class="px-6 py-3 bg-white border border-gray-200 rounded-full text-gray-600 font-medium hover:border-[var(--color-accent)] hover:text-[var(--color-primary)] shadow-sm hover:shadow transition-all">Contact & Inquiry</a>
            </div>
        </div>
    </div>

</div>
@endsection
