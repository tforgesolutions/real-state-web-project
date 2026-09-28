@extends('layouts.app')

@section('title', 'Contact Us | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- PAGE HEADER -->
    <div class="bg-[var(--color-primary)] text-white py-16 lg:py-24 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)] to-transparent z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-fade-up-scroll">
            <nav class="flex items-center justify-center text-sm text-gray-400 space-x-2 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <span class="text-white font-medium">Contact</span>
            </nav>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Let’s Find the Right Property for You</h1>
            <p class="text-gray-300 max-w-2xl mx-auto text-lg">Whether you are looking to buy, rent, or sell, our experts are ready to assist you every step of the way.</p>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-[-3rem] md:mt-[-4rem] relative z-20">
        
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            
            <!-- LEFT COLUMN: Contact Cards & Map -->
            <div class="w-full lg:w-5/12 flex flex-col gap-6 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <!-- Contact Cards -->
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 flex flex-col gap-8 h-full">
                    <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-2">Get in Touch</h3>
                    <p class="text-gray-500 mb-2">Reach out to us through any of the channels below.</p>
                    
                    <div class="space-y-6">
                        <!-- Phone -->
                        <div class="flex items-start group">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-[var(--color-accent)] mr-4 group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors duration-300 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-1">Phone</h4>
                                <a href="tel:+12345678900" class="text-gray-600 hover:text-[var(--color-accent)] transition-colors">+1 (234) 567-8900</a>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start group">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-[var(--color-accent)] mr-4 group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors duration-300 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-1">Email</h4>
                                <a href="mailto:inquiry@aurarealestate.com" class="text-gray-600 hover:text-[var(--color-accent)] transition-colors">inquiry@aurarealestate.com</a>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="flex items-start group">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-[var(--color-accent)] mr-4 group-hover:bg-[#25D366] group-hover:text-white transition-colors duration-300 flex-shrink-0">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-1">WhatsApp</h4>
                                <a href="https://wa.me/12345678900" class="text-gray-600 hover:text-[var(--color-accent)] transition-colors">+1 (234) 567-8900</a>
                            </div>
                        </div>

                        <!-- Office -->
                        <div class="flex items-start group">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-[var(--color-accent)] mr-4 group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors duration-300 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-1">Corporate Office</h4>
                                <p class="text-gray-600">123 Luxury Avenue, Suite 500<br>Metropolis, NY 10001</p>
                            </div>
                        </div>

                        <!-- Hours -->
                        <div class="flex items-start group">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-[var(--color-accent)] mr-4 group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors duration-300 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-1">Business Hours</h4>
                                <p class="text-gray-600">Mon - Fri: 9:00 AM - 6:00 PM<br>Sat - Sun: By Appointment</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Map Placeholder -->
                <div class="bg-gray-100 rounded-3xl overflow-hidden shadow-md h-64 relative group border border-gray-100 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1774&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-multiply grayscale transition-transform duration-700 group-hover:scale-105">
                    <div class="relative z-10 bg-white/90 backdrop-blur-sm px-6 py-3 rounded-full shadow-lg font-bold text-[var(--color-primary)] flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        View on Map
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Contact Form -->
            <div class="w-full lg:w-7/12 animate-fade-up-scroll" style="animation-delay: 0.2s;">
                <div class="bg-white rounded-3xl p-8 lg:p-12 shadow-2xl border border-gray-100 h-full">
                    
                    @php
                        // Check if pre-filled property data exists via query string
                        $propertyQuery = request('property');
                    @endphp

                    <h2 class="font-heading text-3xl font-bold text-[var(--color-primary)] mb-8">Send an Inquiry</h2>

                    <!-- Property Context (Conditional) -->
                    @if($propertyQuery)
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-8 flex items-center">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg mr-4 overflow-hidden flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="text-xs text-[var(--color-accent)] font-bold uppercase tracking-widest">Inquiring about</span>
                                <h4 class="font-bold text-[var(--color-primary)] text-lg line-clamp-1">{{ $propertyQuery }}</h4>
                            </div>
                        </div>
                    @endif

                    <form id="contactForm" class="space-y-6" onsubmit="handleContactSubmit(event)">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors">
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" name="phone" id="phone" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors">
                            </div>
                            
                            <!-- Inquiry Type -->
                            <div>
                                <label for="inquiry_type" class="block text-sm font-semibold text-gray-700 mb-2">Inquiry Type <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="inquiry_type" id="inquiry_type" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 appearance-none focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors">
                                        <option value="" disabled selected>Select an option</option>
                                        <option value="Property Inquiry" {{ $propertyQuery ? 'selected' : '' }}>Property Inquiry</option>
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Buying Assistance">Buying Assistance</option>
                                        <option value="Renting Assistance">Renting Assistance</option>
                                        <option value="Selling / Listing">Selling / Listing</option>
                                        <option value="Agent / Agency Inquiry">Agent / Agency Inquiry</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preferred Contact Method -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Preferred Contact Method</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="radio" name="contact_method" value="Email" class="form-radio text-[var(--color-accent)] focus:ring-[var(--color-accent)] h-4 w-4 border-gray-300" checked>
                                    <span class="ml-2 text-gray-600 group-hover:text-gray-900">Email</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="radio" name="contact_method" value="Phone" class="form-radio text-[var(--color-accent)] focus:ring-[var(--color-accent)] h-4 w-4 border-gray-300">
                                    <span class="ml-2 text-gray-600 group-hover:text-gray-900">Phone Call</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="radio" name="contact_method" value="WhatsApp" class="form-radio text-[var(--color-accent)] focus:ring-[var(--color-accent)] h-4 w-4 border-gray-300">
                                    <span class="ml-2 text-gray-600 group-hover:text-gray-900">WhatsApp</span>
                                </label>
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message <span class="text-red-500">*</span></label>
                            <textarea id="message" name="message" rows="5" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors placeholder-gray-400" placeholder="{{ $propertyQuery ? 'I would like more information about this property...' : 'How can we help you?' }}"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" id="submitBtn" class="w-full md:w-auto bg-[var(--color-primary)] text-white hover:bg-[var(--color-primary-light)] font-bold py-4 px-10 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center group">
                                <span id="submitText">Submit Inquiry</span>
                                <svg id="submitIcon" class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                
                                <svg id="loadingIcon" class="animate-spin w-5 h-5 ml-2 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </button>
                        </div>

                        <!-- Form Message UI (Hidden initially) -->
                        <div id="formSuccessMsg" class="hidden mt-6 bg-green-50 text-green-800 p-4 rounded-xl border border-green-200 flex items-start">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <div>
                                <h4 class="font-bold text-sm">Inquiry Received Successfully!</h4>
                                <p class="text-sm mt-1 text-green-700">Thank you for contacting us. This is a frontend demonstration, so no database entry was created, but in a real environment, our team would reach out to you shortly.</p>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- FAQ SECTION -->
        <div class="mt-24 max-w-3xl mx-auto animate-fade-up-scroll" style="animation-delay: 0.3s;">
            <div class="text-center mb-10">
                <h2 class="font-heading text-3xl font-bold text-[var(--color-primary)] mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-500">Quick answers to common questions about our platform and services.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" id="faqAccordion">
                
                <!-- FAQ Item 1 -->
                <div class="border-b border-gray-100">
                    <button class="w-full text-left px-6 py-5 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-semibold text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">How can I search for a property?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-5 text-gray-500 hidden faq-content text-sm leading-relaxed">
                        You can search for properties by visiting our Home page and using the main search bar, or navigate to our Properties page to apply detailed filters like price range, location, bedrooms, and property type.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border-b border-gray-100">
                    <button class="w-full text-left px-6 py-5 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-semibold text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">Can I submit my property for listing?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-5 text-gray-500 hidden faq-content text-sm leading-relaxed">
                        Yes, property owners and agents can list properties. Click the "List Property" button in the navigation bar to access our step-by-step submission wizard to enter your property details and upload photos.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border-b border-gray-100">
                    <button class="w-full text-left px-6 py-5 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-semibold text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">How does the property inquiry process work?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-5 text-gray-500 hidden faq-content text-sm leading-relaxed">
                        When you submit an inquiry through our form, it is instantly routed to the dedicated agent or agency handling that property. They will respond to you via your preferred contact method (Email, Phone, or WhatsApp) within 24 hours.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="border-b border-gray-100">
                    <button class="w-full text-left px-6 py-5 flex justify-between items-center focus:outline-none group faq-btn" aria-expanded="false">
                        <span class="font-semibold text-[var(--color-primary)] group-hover:text-[var(--color-accent)] transition-colors">Can I compare or save properties?</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 group-hover:text-[var(--color-accent)] faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-5 text-gray-500 hidden faq-content text-sm leading-relaxed">
                        Absolutely. Click the Heart icon on any property card to save it to your Favorites. You can also click the Compare icon (scales) to add up to 4 properties to a side-by-side comparison table to evaluate their features.
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- CTA SECTION -->
    <div class="mt-24 bg-[var(--color-primary)] text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-fade-up-scroll">
            <h2 class="font-heading text-3xl md:text-5xl font-bold mb-6">Looking for a Property?</h2>
            <p class="text-gray-300 max-w-2xl mx-auto text-lg mb-10">Explore properties, compare your options, and connect with the right people to make your real estate dreams a reality.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('home') }}" class="btn-primary py-4 px-10 rounded-xl font-bold shadow-lg text-lg flex items-center justify-center">
                    Explore Properties
                </a>
                <a href="{{ route('properties.create') }}" class="bg-transparent border border-white hover:bg-white hover:text-[var(--color-primary)] py-4 px-10 rounded-xl font-bold transition-colors duration-300 text-lg flex items-center justify-center">
                    List Your Property
                </a>
            </div>
        </div>
    </div>

</div>

<script>
    // Form Submission Handler
    function handleContactSubmit(event) {
        event.preventDefault();
        
        const form = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitIcon = document.getElementById('submitIcon');
        const loadingIcon = document.getElementById('loadingIcon');
        const successMsg = document.getElementById('formSuccessMsg');

        // Loading State
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
        submitText.innerText = 'Sending...';
        submitIcon.classList.add('hidden');
        loadingIcon.classList.remove('hidden');
        successMsg.classList.add('hidden');

        // Actual network request
        const formData = new FormData(form);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Add property parameter if exists in URL
        const urlParams = new URLSearchParams(window.location.search);
        const propTitle = urlParams.get('property');
        if (propTitle && !formData.has('property_id')) {
            // We pass it as part of the message or handle it if we have ID
            formData.append('inquiry_type', 'Property Inquiry - ' + propTitle);
        }
        
        fetch('{{ route("contact.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Success State
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-80', 'cursor-not-allowed');
            submitText.innerText = 'Submit Inquiry';
            submitIcon.classList.remove('hidden');
            loadingIcon.classList.add('hidden');
            
            successMsg.classList.remove('hidden');
            
            // Show toast
            if(window.AuraToast) window.AuraToast.show(data.message, 'success');

            // Reset form fields
            form.reset();
        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-80', 'cursor-not-allowed');
            submitText.innerText = 'Submit Inquiry';
            submitIcon.classList.remove('hidden');
            loadingIcon.classList.add('hidden');
            if(window.AuraToast) window.AuraToast.show('An error occurred.', 'error');
        });
    }

    // FAQ Accordion Logic
    document.addEventListener('DOMContentLoaded', () => {
        const faqBtns = document.querySelectorAll('.faq-btn');
        
        faqBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const content = btn.nextElementSibling;
                const icon = btn.querySelector('.faq-icon');
                const isExpanded = btn.getAttribute('aria-expanded') === 'true';
                
                // Close all other open accordions
                faqBtns.forEach(otherBtn => {
                    if (otherBtn !== btn) {
                        otherBtn.setAttribute('aria-expanded', 'false');
                        otherBtn.nextElementSibling.classList.add('hidden');
                        otherBtn.querySelector('.faq-icon').classList.remove('rotate-180');
                    }
                });

                // Toggle current accordion
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
    });
</script>
@endsection
