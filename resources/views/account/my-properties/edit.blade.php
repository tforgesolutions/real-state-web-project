@extends('layouts.app')

@section('title', 'Edit Property | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- PAGE HERO -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 animate-fade-up-scroll">
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-4">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">List Property</span>
        </nav>
        
        <div class="bg-gradient-to-r from-[var(--color-primary)] to-[var(--color-primary-light)] rounded-3xl p-8 md:p-12 text-white relative overflow-hidden shadow-xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-[var(--color-accent)] opacity-20 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
            <div class="relative z-10 max-w-2xl">
                <h1 class="font-heading text-3xl md:text-5xl font-bold mb-4">Edit Property</h1>
                <p class="text-gray-300 text-lg">Showcase your property to the right audience. Complete the details below to publish your listing on our premium network.</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- FORM SECTION -->
            <div class="w-full lg:w-2/3">
                
                <!-- SUCCESS STATE -->
                <div id="successState" class="hidden bg-white border border-green-100 rounded-3xl p-10 text-center shadow-sm">
                    <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="font-heading text-3xl font-bold text-[var(--color-primary)] mb-4">Property Submitted!</h2>
                    <p class="text-gray-600 text-lg mb-8">Thank you for listing with Aura. Your property has been successfully submitted and is currently under review by our team.</p>
                    <a href="{{ route('home') }}" class="btn-primary px-8 py-3 rounded-lg text-lg">Return to Home</a>
                </div>

                <!-- MAIN FORM -->
                <div id="formContainer" class="bg-white border border-gray-100 rounded-3xl p-6 md:p-10 shadow-sm relative animate-fade-up-scroll" style="animation-delay: 0.1s;">
                    
                    <!-- Progress Bar -->
                    <div class="mb-10">
                        <div class="flex justify-between text-xs font-semibold text-gray-400 mb-2 px-1">
                            <span>Step <span id="currentStepText">1</span> of 7</span>
                            <span id="stepTitleText">Purpose</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div id="progressBar" class="bg-[var(--color-accent)] h-2 rounded-full transition-all duration-500" style="width: 14.28%"></div>
                        </div>
                    </div>

                    <form id="listingForm" action="{{ route('account.my-properties.update', $property) }}" method="POST" enctype="multipart/form-data" onsubmit="return event.submitter.id === 'draftBtn' || validateCurrentStep();">
                        @csrf
                        @method('PUT')
                        
                        @if ($errors->any())
                            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- STEP 1: PURPOSE & TYPE -->
                        <div class="form-step active" data-step="1" data-title="Purpose & Type">
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">What are you looking to do?</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Property Purpose *</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="purpose" value="buy" class="peer sr-only" required>
                                            <div class="p-4 border-2 border-gray-100 rounded-xl text-center hover:bg-gray-50 peer-checked:border-[var(--color-accent)] peer-checked:bg-[var(--color-surface-alt)] transition-colors">
                                                <div class="font-bold text-[var(--color-primary)]">Sell</div>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="purpose" value="rent" class="peer sr-only">
                                            <div class="p-4 border-2 border-gray-100 rounded-xl text-center hover:bg-gray-50 peer-checked:border-[var(--color-accent)] peer-checked:bg-[var(--color-surface-alt)] transition-colors">
                                                <div class="font-bold text-[var(--color-primary)]">Rent</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Property Category *</label>
                                    <div class="grid grid-cols-3 gap-4">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="property_category" value="Residential" class="peer sr-only" required>
                                            <div class="p-4 border-2 border-gray-100 rounded-xl text-center hover:bg-gray-50 peer-checked:border-[var(--color-accent)] peer-checked:bg-[var(--color-surface-alt)] transition-colors">
                                                <svg class="w-6 h-6 mx-auto mb-2 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                                <div class="font-bold text-[var(--color-primary)] text-sm">Residential</div>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="property_category" value="Commercial" class="peer sr-only">
                                            <div class="p-4 border-2 border-gray-100 rounded-xl text-center hover:bg-gray-50 peer-checked:border-[var(--color-accent)] peer-checked:bg-[var(--color-surface-alt)] transition-colors">
                                                <svg class="w-6 h-6 mx-auto mb-2 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                <div class="font-bold text-[var(--color-primary)] text-sm">Commercial</div>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="property_category" value="Plot/Land" class="peer sr-only">
                                            <div class="p-4 border-2 border-gray-100 rounded-xl text-center hover:bg-gray-50 peer-checked:border-[var(--color-accent)] peer-checked:bg-[var(--color-surface-alt)] transition-colors">
                                                <svg class="w-6 h-6 mx-auto mb-2 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <div class="font-bold text-[var(--color-primary)] text-sm">Plot / Land</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: PROPERTY DETAILS -->
                        <div class="form-step hidden" data-step="2" data-title="Property Details">
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Basic Details</h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Property Title *</label>
                                    <input type="text" id="propertyTitle" name="title" required placeholder="e.g. Modern Luxury Villa in Beverly Hills" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Property Type *</label>
                                        <select id="propertyType" name="property_type" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all appearance-none">
                                            <option value="">Select Type</option>
                                            <option value="House">House</option>
                                            <option value="Apartment">Apartment</option>
                                            <option value="Villa">Villa</option>
                                            <option value="Penthouse">Penthouse</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Area / Size *</label>
                                        <div class="flex">
                                            <input type="number" id="areaSize" name="area" required placeholder="Size" class="w-2/3 px-4 py-3 bg-gray-50 border border-gray-200 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] border-r-0 transition-all">
                                            <select id="areaUnit" name="area_unit" class="w-1/3 px-4 py-3 bg-gray-100 border border-gray-200 rounded-r-lg focus:outline-none transition-all appearance-none text-gray-600 font-medium">
                                                <option value="Sq Ft">Sq Ft</option>
                                                <option value="Sq Yd">Sq Yd</option>
                                                <option value="Marla">Marla</option>
                                                <option value="Kanal">Kanal</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bedrooms</label>
                                        <input type="number" id="bedrooms" name="bedrooms" min="0" placeholder="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bathrooms</label>
                                        <input type="number" id="bathrooms" name="bathrooms" min="0" placeholder="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Garages/Parking</label>
                                        <input type="number" id="garages" name="parking" min="0" placeholder="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Year Built</label>
                                        <input type="number" id="yearBuilt" name="construction_year" min="1900" max="2030" placeholder="e.g. 2022" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3: LOCATION -->
                        <div class="form-step hidden" data-step="3" data-title="Location">
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Property Location</h3>
                            
                            <div class="space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Country *</label>
                                        <select id="country" name="country" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all appearance-none">
                                            <option value="United States">United States</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                            <option value="Pakistan">Pakistan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">City *</label>
                                        <input type="text" id="city" name="city" required placeholder="City name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Area / Society / Community</label>
                                    <input type="text" id="area" name="area_locality" placeholder="e.g. Beverly Hills, Downtown" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Complete Address *</label>
                                    <input type="text" id="address" name="address" required placeholder="House/Flat number, Street name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- STEP 4: PRICING & FEATURES -->
                        <div class="form-step hidden" data-step="4" data-title="Pricing & Features">
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Price & Amenities</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Asking Price *</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">$</span>
                                        <input type="number" id="price" name="price" required placeholder="0" class="w-full pl-8 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all text-lg font-bold">
                                    </div>
                                    <div class="mt-3 flex items-center">
                                        <input type="checkbox" id="negotiable" name="negotiable" value="1" class="w-4 h-4 text-[var(--color-accent)] focus:ring-[var(--color-accent)] border-gray-300 rounded cursor-pointer">
                                        <label for="negotiable" class="ml-2 text-sm text-gray-600 cursor-pointer">Price is negotiable</label>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-700 mb-4">Select Amenities</label>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        <!-- Amenities checkboxes -->
                                        @foreach(['Electricity', 'Gas', 'Water Supply', 'Security Staff', 'CCTV', 'Central A/C', 'Balcony', 'Garden', 'Swimming Pool', 'Elevator', 'Furnished', 'Home Theater'] as $amenity)
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="checkbox" value="{{ $amenity }}" name="amenities[]" class="amenity-cb w-4 h-4 text-[var(--color-accent)] focus:ring-[var(--color-accent)] border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-600">{{ $amenity }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                                    <textarea id="description" name="description" rows="5" required placeholder="Describe the property, key features, and surrounding neighborhood..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all resize-y"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 5: MEDIA -->
                        <div class="form-step hidden" data-step="5" data-title="Media">
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Photos & Video</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Property Images *</label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-10 text-center hover:border-[var(--color-accent)] hover:bg-[var(--color-surface-alt)] transition-colors cursor-pointer relative" id="dropArea">
                                        <input type="file" id="imageUpload" name="images[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <h4 class="font-bold text-gray-700 mb-1">Click or drag images here</h4>
                                        <p class="text-sm text-gray-500">JPG, PNG up to 5MB each. First image will be the cover.</p>
                                    </div>
                                    <div id="imagePreviewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 empty:hidden">
                                        <!-- Image previews will be injected here by JS -->
                                    </div>
                                    <p id="imageError" class="text-red-500 text-xs mt-2 hidden">Please select at least one image.</p>
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Video URL (Optional)</label>
                                    <input type="url" id="videoUrl" name="video_url" placeholder="YouTube or Vimeo link" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- STEP 6: CONTACT -->
                        <div class="form-step hidden" data-step="6" data-title="Contact Info">
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Your Details</h3>
                            
                            <div class="space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                        <input type="text" id="contactName" name="contact_name" required placeholder="John Doe" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                        <input type="email" id="contactEmail" name="contact_email" required placeholder="john@example.com" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                        <input type="tel" id="contactPhone" name="contact_phone" required placeholder="+1 234 567 8900" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">WhatsApp Number (Optional)</label>
                                        <input type="tel" id="contactWhatsapp" name="contact_whatsapp" placeholder="+1 234 567 8900" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <label class="flex items-start cursor-pointer">
                                        <input type="checkbox" id="showContact" name="preferred_contact_method" value="Phone" checked class="mt-1 w-4 h-4 text-[var(--color-accent)] focus:ring-[var(--color-accent)] border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-600">Show my contact information publicly on this listing. If unchecked, interested buyers will contact you via a form sent to your email.</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 7: REVIEW -->
                        <div class="form-step hidden" data-step="7" data-title="Review">
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Review Listing</h3>
                            
                            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 mb-6">
                                <div class="flex justify-between items-start border-b border-gray-200 pb-4 mb-4">
                                    <div>
                                        <span id="revPurpose" class="bg-[var(--color-primary)] text-white text-xs font-semibold px-2 py-1 rounded uppercase mr-2">Sell</span>
                                        <span id="revType" class="text-sm text-[var(--color-accent)] font-bold uppercase">House</span>
                                        <h4 id="revTitle" class="text-xl font-bold text-gray-900 mt-2">Title Goes Here</h4>
                                        <p id="revLocation" class="text-gray-500 text-sm flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            City, Country
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div id="revPrice" class="text-2xl font-bold text-[var(--color-primary)]">$0</div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                    <div class="text-sm"><span class="block text-gray-400 text-xs uppercase">Beds</span> <strong id="revBeds">-</strong></div>
                                    <div class="text-sm"><span class="block text-gray-400 text-xs uppercase">Baths</span> <strong id="revBaths">-</strong></div>
                                    <div class="text-sm"><span class="block text-gray-400 text-xs uppercase">Size</span> <strong id="revArea">-</strong></div>
                                    <div class="text-sm"><span class="block text-gray-400 text-xs uppercase">Contact</span> <strong id="revContactName">-</strong></div>
                                </div>

                                <div class="text-sm text-gray-600 line-clamp-3 italic mb-4" id="revDescription">
                                    Description preview...
                                </div>
                                
                                <div id="revImages" class="flex gap-2 overflow-x-auto pb-2">
                                    <!-- Image thumbnails -->
                                </div>
                            </div>
                            
                            <p class="text-sm text-gray-500 mb-6">By submitting this listing, you agree to Aura's Terms of Service and acknowledge that your listing will undergo review before going live.</p>
                        </div>

                        <!-- NAVIGATION BUTTONS -->
                        <div class="flex justify-between mt-10 pt-6 border-t border-gray-100">
                            <button type="button" id="prevBtn" class="btn-secondary px-6 py-2.5 rounded-lg hidden">
                                Back
                            </button>
                            <div class="ml-auto">
                                <button type="button" id="nextBtn" class="btn-primary px-8 py-2.5 rounded-lg">
                                    Next Step
                                </button>
                                <button type="submit" name="is_draft" value="1" id="draftBtn" class="btn-secondary px-6 py-2.5 rounded-lg mr-2">
                                    Save Draft
                                </button>
                                <button type="submit" id="submitBtn" class="btn-primary bg-green-600 hover:bg-green-700 hover:shadow-green-600/30 px-8 py-2.5 rounded-lg hidden">
                                    Submit Listing
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

            <!-- TRUST / GUIDANCE SIDEBAR -->
            <div class="w-full lg:w-1/3">
                <div class="sticky top-28 bg-[var(--color-primary)] rounded-3xl p-8 text-white shadow-xl animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-[var(--color-accent)] mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-heading text-2xl font-bold mb-4">Tips for a Great Listing</h3>
                    
                    <ul class="space-y-6">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-[var(--color-accent)] mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <h4 class="font-bold text-sm">Use High-Quality Photos</h4>
                                <p class="text-xs text-gray-400 mt-1">Listings with professional, well-lit photos receive up to 3x more inquiries.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-[var(--color-accent)] mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <h4 class="font-bold text-sm">Be Accurate</h4>
                                <p class="text-xs text-gray-400 mt-1">Ensure square footage, room counts, and location details are exact to build trust.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-[var(--color-accent)] mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <h4 class="font-bold text-sm">Write a Compelling Description</h4>
                                <p class="text-xs text-gray-400 mt-1">Highlight unique features, neighborhood perks, and recent upgrades.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-[var(--color-accent)] mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <h4 class="font-bold text-sm">Price Competitively</h4>
                                <p class="text-xs text-gray-400 mt-1">Research similar properties in your area to set a realistic asking price.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.form-step');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        const progressBar = document.getElementById('progressBar');
        const currentStepText = document.getElementById('currentStepText');
        const stepTitleText = document.getElementById('stepTitleText');
        
        let currentStep = 0;
        const totalSteps = steps.length;
        let uploadedImages = [];

        // Image Upload Logic
        const imageUpload = document.getElementById('imageUpload');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const imageError = document.getElementById('imageError');

        imageUpload.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            imageError.classList.add('hidden');

            files.forEach(file => {
                if(file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        uploadedImages.push(e.target.result);
                        renderImagePreviews();
                    }
                    reader.readAsDataURL(file);
                }
            });
        });

        function renderImagePreviews() {
            previewContainer.innerHTML = '';
            uploadedImages.forEach((src, index) => {
                const div = document.createElement('div');
                div.className = 'relative rounded-lg overflow-hidden h-24 border border-gray-200';
                div.innerHTML = `
                    <img src="${src}" class="w-full h-full object-cover">
                    <button type="button" onclick="removeImage(${index})" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors">&times;</button>
                `;
                previewContainer.appendChild(div);
            });
        }

        window.removeImage = function(index) {
            uploadedImages.splice(index, 1);
            renderImagePreviews();
        }

        // Navigation Logic
        function updateUI() {
            steps.forEach((step, index) => {
                if (index === currentStep) {
                    step.classList.remove('hidden');
                    step.classList.add('animate-fade-up-scroll');
                    currentStepText.innerText = index + 1;
                    stepTitleText.innerText = step.dataset.title;
                    progressBar.style.width = `${((index + 1) / totalSteps) * 100}%`;
                } else {
                    step.classList.add('hidden');
                    step.classList.remove('animate-fade-up-scroll');
                }
            });

            if (currentStep === 0) {
                prevBtn.classList.add('hidden');
            } else {
                prevBtn.classList.remove('hidden');
            }

            if (currentStep === totalSteps - 1) {
                nextBtn.classList.add('hidden');
                submitBtn.classList.remove('hidden');
                
                populateReview();
            } else {
                nextBtn.classList.remove('hidden');
                submitBtn.classList.add('hidden');
                
            }
        }

        function validateCurrentStep() {
            const currentStepEl = steps[currentStep];
            const requiredFields = currentStepEl.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (field.type === 'radio') {
                    const name = field.name;
                    const checked = currentStepEl.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) isValid = false;
                } else if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            // Special validation for media step
            if(currentStep === 4 && uploadedImages.length === 0) {
                imageError.classList.remove('hidden');
                isValid = false;
            }

            if(!isValid) {
                // simple visual shake or error could go here
            }
            return isValid;
        }

        function populateReview() {
            // Get values
            const purpose = document.querySelector('input[name="purpose"]:checked')?.value || 'Sell';
            const type = document.getElementById('propertyType').value || 'House';
            const title = document.getElementById('propertyTitle').value || 'Untitled Property';
            const city = document.getElementById('city').value || '';
            const country = document.getElementById('country').value || '';
            const price = document.getElementById('price').value || '0';
            const beds = document.getElementById('bedrooms').value || '-';
            const baths = document.getElementById('bathrooms').value || '-';
            const area = document.getElementById('areaSize').value || '-';
            const areaUnit = document.getElementById('areaUnit').value || 'Sq Ft';
            const contactName = document.getElementById('contactName').value || 'Unknown';
            const desc = document.getElementById('description').value || 'No description provided.';

            // Set Review Values
            document.getElementById('revPurpose').innerText = purpose;
            document.getElementById('revType').innerText = type;
            document.getElementById('revTitle').innerText = title;
            document.getElementById('revLocation').innerHTML = `<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> ${city}, ${country}`;
            document.getElementById('revPrice').innerText = `$${Number(price).toLocaleString()}`;
            document.getElementById('revBeds').innerText = beds;
            document.getElementById('revBaths').innerText = baths;
            document.getElementById('revArea').innerText = `${area} ${areaUnit}`;
            document.getElementById('revContactName').innerText = contactName;
            document.getElementById('revDescription').innerText = desc;

            // Set images
            const revImages = document.getElementById('revImages');
            revImages.innerHTML = '';
            uploadedImages.slice(0, 4).forEach(src => {
                revImages.innerHTML += `<img src="${src}" class="w-16 h-16 rounded object-cover border border-gray-200">`;
            });
            if(uploadedImages.length > 4) {
                revImages.innerHTML += `<div class="w-16 h-16 rounded bg-gray-100 flex items-center justify-center text-xs text-gray-500 font-bold">+${uploadedImages.length - 4}</div>`;
            }
        }

        nextBtn.addEventListener('click', () => {
            if (validateCurrentStep()) {
                currentStep++;
                updateUI();
                window.scrollTo({ top: document.getElementById('formContainer').offsetTop - 100, behavior: 'smooth' });
            }
        });

        prevBtn.addEventListener('click', () => {
            currentStep--;
            updateUI();
            window.scrollTo({ top: document.getElementById('formContainer').offsetTop - 100, behavior: 'smooth' });
        });

        // Clear error styles on input
        document.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        });

        // Initialization
        updateUI();

        // Submit logic
        window.submitForm = function() {
            if(validateCurrentStep()) {
                document.getElementById('formContainer').classList.add('hidden');
                const successState = document.getElementById('successState');
                successState.classList.remove('hidden');
                successState.classList.add('animate-fade-up-scroll');
                window.scrollTo({ top: successState.offsetTop - 100, behavior: 'smooth' });
            }
        }
    });
</script>
@endsection




<script>
document.addEventListener('DOMContentLoaded', function() {
    const p = @json(old() ?: $property);
    
    if(p) {
        if(p.purpose) {
            const el = document.querySelector(input[name="purpose"][value=" + p.purpose + "]);
            if(el) el.checked = true;
        }
        if(p.property_category) {
            const el = document.querySelector(input[name="property_category"][value=" + p.property_category + "]);
            if(el) el.checked = true;
        }
        
        if(p.title) document.getElementById('propertyTitle').value = p.title;
        if(p.property_type) document.getElementById('propertyType').value = p.property_type;
        if(p.area) document.getElementById('areaSize').value = p.area;
        if(p.area_unit) document.getElementById('areaUnit').value = p.area_unit;
        if(p.bedrooms) document.getElementById('bedrooms').value = p.bedrooms;
        if(p.bathrooms) document.getElementById('bathrooms').value = p.bathrooms;
        if(p.parking) document.getElementById('garages').value = p.parking;
        if(p.construction_year) document.getElementById('yearBuilt').value = p.construction_year;
        if(p.country) document.getElementById('country').value = p.country;
        if(p.city) document.getElementById('city').value = p.city;
        if(p.area_locality) document.getElementById('area').value = p.area_locality;
        if(p.address) document.getElementById('address').value = p.address;
        if(p.price) document.getElementById('price').value = p.price;
        if(p.negotiable) document.getElementById('negotiable').checked = true;
        if(p.description) document.getElementById('description').value = p.description;
        if(p.video_url) document.getElementById('videoUrl').value = p.video_url;
        if(p.contact_name) document.getElementById('contactName').value = p.contact_name;
        if(p.contact_email) document.getElementById('contactEmail').value = p.contact_email;
        if(p.contact_phone) document.getElementById('contactPhone').value = p.contact_phone;
        if(p.contact_whatsapp) document.getElementById('contactWhatsapp').value = p.contact_whatsapp;
        
        if(p.amenities && Array.isArray(p.amenities)) {
            p.amenities.forEach(amenity => {
                const cb = document.querySelector(.amenity-cb[value=" + amenity + "]);
                if(cb) cb.checked = true;
            });
        }
    }
});
</script>



