@extends('layouts.app')

@php
    $pTitle = isset($realProperty) ? $realProperty->title : 'Modern Luxury Villa';
    $pLocation = isset($realProperty) ? $realProperty->city . ', ' . $realProperty->area_locality : 'Beverly Hills, CA';
    $pPurpose = isset($realProperty) ? ($realProperty->purpose === 'buy' ? 'For Sale' : 'For Rent') : 'For Sale';
    $pFeatured = isset($realProperty) ? $realProperty->is_featured : true;
    $pRefId = isset($realProperty) ? $realProperty->reference_id : 'AUR-8924';
    $pAddress = isset($realProperty) ? ($realProperty->address ?? $pLocation) : '90210 Beverly Hills, California, USA';
    $pPrice = isset($realProperty) ? '$' . number_format($realProperty->price) : '$5,200,000';
    $pBeds = isset($realProperty) ? $realProperty->bedrooms : 5;
    $pBaths = isset($realProperty) ? $realProperty->bathrooms : 6;
    $pArea = isset($realProperty) ? $realProperty->area : '6,500';
    $pType = isset($realProperty) ? $realProperty->property_type : 'Villa';
    $pDesc = isset($realProperty) ? $realProperty->description : '<p>Experience the pinnacle of luxury living in this architectural masterpiece located in the exclusive enclaves of Beverly Hills. Designed by world-renowned architects, this modern villa perfectly blends indoor and outdoor spaces, offering breathtaking panoramic views of the city skyline and the ocean.</p><p>Upon entering through the grand pivoting glass door, you are welcomed into an expansive open-concept living area featuring soaring 14-foot ceilings, automated floor-to-ceiling fleetwood doors, and a spectacular central floating staircase. The gourmet chef\'s kitchen is equipped with top-of-the-line Miele appliances, custom Italian cabinetry, and a massive marble center island perfect for entertaining.</p>';
    
    $pMedia = [];
    if(isset($realProperty) && !empty($realProperty->images)) {
        foreach($realProperty->images as $idx => $img) {
            $pMedia[] = [
                'type' => 'image',
                'url' => Storage::url($img),
                'thumbnail' => Storage::url($img),
                'title' => 'Image ' . ($idx + 1)
            ];
        }
    }
@endphp

@section('title', $pTitle . ' | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <!-- BREADCRUMB & HEADER -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 animate-fade-up-scroll">
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-4">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('properties.index') }}" class="hover:text-[var(--color-primary)] transition-colors">Properties</a>
            <span>/</span>
            <a href="{{ route('properties.index', ['city' => $pLocation]) }}" class="hover:text-[var(--color-primary)] transition-colors">{{ $pLocation }}</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">{{ $pTitle }}</span>
        </nav>
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="bg-[var(--color-primary)]/90 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">{{ $pPurpose }}</span>
                    @if($pFeatured)
                        <span class="bg-[var(--color-accent)] text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Featured</span>
                    @endif
                    <span class="text-xs text-gray-500 font-medium">ID: {{ $pRefId }}</span>
                </div>
                <h1 class="font-heading text-3xl md:text-5xl font-bold text-[var(--color-primary)] mb-2">{{ $pTitle }}</h1>
                <p class="text-gray-500 flex items-center text-lg">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $pAddress }}
                </p>
            </div>
            <div class="text-left md:text-right">
                <div class="text-3xl md:text-4xl font-bold text-[var(--color-primary)]">{{ $pPrice }}</div>
                <div class="flex items-center gap-2 mt-3">
                    <button class="flex items-center justify-center p-2.5 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-red-500 hover:border-red-500 hover:bg-red-50 transition-all focus:outline-none shadow-sm" title="Save to Favorites">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <button onclick="shareProperty('{{ $pTitle }}', '{{ $pAddress }}')" class="flex items-center justify-center p-2.5 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[var(--color-accent)] hover:border-[var(--color-accent)] hover:bg-[var(--color-surface-alt)] transition-all focus:outline-none shadow-sm" title="Share Property">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    </button>
                    <a href="{{ route('contact.index', ['property' => $pTitle]) }}" class="btn-primary px-4 py-2 text-sm rounded-lg flex items-center md:hidden">
                        Contact Agent
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($pMedia))
        <x-property-gallery :media="$pMedia" />
    @else
        <x-property-gallery />
    @endif
    
    <!-- CONTENT GRID -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-10">
        
        <!-- LEFT COLUMN: MAIN DETAILS -->
        <div class="w-full lg:w-2/3 space-y-12">
            
            <!-- Quick Features Bar -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex flex-wrap justify-between items-center gap-6 animate-fade-up-scroll" style="animation-delay: 0.2s;">
                <div class="flex flex-col items-center text-center">
                    <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="text-lg font-bold text-[var(--color-primary)]">{{ $pBeds }}</span>
                    <span class="text-xs text-gray-500 uppercase tracking-wider">Bedrooms</span>
                </div>
                <div class="hidden sm:block w-px h-12 bg-gray-200"></div>
                <div class="flex flex-col items-center text-center">
                    <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    <span class="text-lg font-bold text-[var(--color-primary)]">{{ $pBaths }}</span>
                    <span class="text-xs text-gray-500 uppercase tracking-wider">Bathrooms</span>
                </div>
                <div class="hidden sm:block w-px h-12 bg-gray-200"></div>
                <div class="flex flex-col items-center text-center">
                    <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                    <span class="text-lg font-bold text-[var(--color-primary)]">{{ $pArea }}</span>
                    <span class="text-xs text-gray-500 uppercase tracking-wider">Sq Ft</span>
                </div>
                <div class="hidden sm:block w-px h-12 bg-gray-200"></div>
                <div class="flex flex-col items-center text-center">
                    <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    <span class="text-lg font-bold text-[var(--color-primary)]">{{ $pType }}</span>
                    <span class="text-xs text-gray-500 uppercase tracking-wider">Type</span>
                </div>
                <div class="hidden sm:block w-px h-12 bg-gray-200"></div>
                <div class="flex flex-col items-center text-center">
                    <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    <span class="text-lg font-bold text-[var(--color-primary)]">{{ isset($realProperty) ? ($realProperty->parking ?? 'N/A') : '4' }}</span>
                    <span class="text-xs text-gray-500 uppercase tracking-wider">Garages</span>
                </div>
            </div>

            <!-- Description Section -->
            <div class="animate-fade-up-scroll">
                <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Property Description</h2>
                <div class="text-gray-600 space-y-4 leading-relaxed font-light">
                    {!! $pDesc !!}
                </div>
            </div>

            <!-- Amenities Section -->
            <div class="animate-fade-up-scroll">
                <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Amenities & Features</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-y-6 gap-x-4">
                    @php
                        $pAmenities = isset($realProperty) && is_array($realProperty->amenities) ? $realProperty->amenities : ['Swimming Pool', 'Central A/C', 'Smart Security', '4 Car Garage', 'Fully Furnished', 'Home Theater'];
                    @endphp
                    @foreach($pAmenities as $amenity)
                        <div class="flex items-center text-gray-600 group">
                            <div class="w-10 h-10 rounded-full bg-[var(--color-surface-alt)] flex items-center justify-center mr-3 group-hover:bg-[var(--color-accent)] group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            {{ $amenity }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Location Section -->
            <div class="animate-fade-up-scroll">
                <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-6">Location</h2>
                <div class="bg-white border border-gray-100 rounded-2xl p-2 shadow-sm relative overflow-hidden h-[300px]">
                    <!-- Map Placeholder -->
                    <div class="absolute inset-0 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1748&auto=format&fit=crop" class="w-full h-full object-cover opacity-60" alt="Map View">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur rounded-xl p-4 shadow-lg flex justify-between items-center">
                        <div>
                            <h4 class="font-bold text-[var(--color-primary)]">{{ $pLocation }}</h4>
                            <p class="text-sm text-gray-500">{{ $pAddress }}</p>
                        </div>
                        <a href="#" class="btn-secondary text-sm px-4 py-2 border-[var(--color-primary)] text-[var(--color-primary)] rounded-lg hover:bg-[var(--color-primary)] hover:text-white">View on Map</a>
                    </div>
                </div>
            </div>

            <!-- Reviews & Ratings -->
            <x-review-section type="property" :id="isset($realProperty) ? $realProperty->id : $property" title="Property Reviews" />

        </div>

        <!-- RIGHT COLUMN: CONTACT & INQUIRY -->
        <div class="w-full lg:w-1/3">
            <div class="sticky top-28 bg-white border border-gray-100 rounded-2xl shadow-xl overflow-hidden animate-fade-up-scroll" style="animation-delay: 0.3s;">
                
                <!-- Agent Info -->
                <div class="p-6 bg-[var(--color-surface-alt)] border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        @php
                            $agent = isset($realProperty) && $realProperty->user ? $realProperty->user : null;
                        @endphp
                        <img src="{{ $agent && $agent->profile_photo ? Storage::url($agent->profile_photo) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1587&auto=format&fit=crop' }}" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" alt="Agent Profile">
                        <div>
                            <h3 class="font-bold text-lg text-[var(--color-primary)]">
                                @if($agent)
                                    <a href="{{ route('agents.show', $agent->id) }}" class="hover:text-[var(--color-accent)]">{{ $agent->name }}</a>
                                @else
                                    Michael Sterling
                                @endif
                            </h3>
                            <p class="text-sm text-gray-500">{{ $agent->designation ?? 'Luxury Estate Specialist' }}</p>
                            <p class="text-xs font-semibold text-[var(--color-accent)] mt-1">{{ $agent->agency ?? 'Aura Premier Group' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-2 mt-6">
                        <a href="{{ $agent && $agent->phone ? 'tel:'.$agent->phone : '#' }}" class="flex-1 flex items-center justify-center py-2.5 bg-[var(--color-primary)] text-white rounded-lg hover:bg-[var(--color-primary-light)] transition-colors shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            Call
                        </a>
                        <a href="{{ $agent && $agent->whatsapp ? 'https://wa.me/'.preg_replace('/[^0-9]/', '', $agent->whatsapp) : '#' }}" target="_blank" class="flex-1 flex items-center justify-center py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            WhatsApp
                        </a>
                    </div>
                </div>
                
                <!-- Inquiry Form -->
                <div class="p-6">
                    <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-4">Inquire About This Property</h3>
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                        @csrf
                        @if(isset($realProperty))
                            <input type="hidden" name="property_id" value="{{ $realProperty->id }}">
                        @endif
                        <input type="hidden" name="inquiry_type" value="Property Inquiry">
                        <div>
                            <label class="sr-only">Your Name</label>
                            <input type="text" name="name" placeholder="Your Name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <label class="sr-only">Email Address</label>
                            <input type="email" name="email" placeholder="Email Address" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <label class="sr-only">Phone Number</label>
                            <input type="tel" name="phone" placeholder="Phone Number" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all">
                        </div>
                        <div>
                            <label class="sr-only">Message</label>
                            <textarea name="message" rows="4" placeholder="I am interested in this property..." required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-all resize-none"></textarea>
                        </div>
                        <div class="flex items-start mb-4">
                            <input type="checkbox" id="terms" class="mt-1 mr-2 text-[var(--color-accent)] focus:ring-[var(--color-accent)] border-gray-300 rounded" required>
                            <label for="terms" class="text-xs text-gray-500">I agree to the Terms of Service and Privacy Policy. I consent to be contacted by Aura agents.</label>
                        </div>
                        <button type="submit" class="w-full btn-primary py-3 rounded-lg shadow-md text-lg">
                            Send Inquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- SIMILAR PROPERTIES -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24 mb-10 animate-fade-up-scroll">
        <div class="flex justify-between items-end mb-8">
            <h2 class="font-heading text-3xl font-bold text-[var(--color-primary)]">Similar Properties</h2>
            <a href="{{ route('properties.index') }}" class="text-[var(--color-accent)] font-semibold hover:underline">View All</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $similarProperties = \App\Models\Property::where('status', 'approved')
                    ->when(isset($realProperty), function($q) use ($realProperty) {
                        return $q->where('id', '!=', $realProperty->id)
                                 ->where('property_category', $realProperty->property_category);
                    })
                    ->latest()
                    ->take(3)
                    ->get();
            @endphp
            
            @forelse($similarProperties as $prop)
                @php
                    $img = !empty($prop->images) ? Storage::url($prop->images[0]) : 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1740&auto=format&fit=crop';
                @endphp
                <x-property-card 
                    :image="$img"
                    :title="$prop->title"
                    :location="$prop->city . ', ' . $prop->area_locality"
                    :type="$prop->property_type"
                    :status="$prop->purpose === 'buy' ? 'For Sale' : 'For Rent'"
                    :price="'$'.number_format($prop->price)"
                    :bedrooms="$prop->bedrooms"
                    :bathrooms="$prop->bathrooms"
                    :area="$prop->area . ' sqft'"
                    layout="grid"
                    :link="route('properties.show', $prop->slug)"
                />
            @empty
                <p class="text-gray-500 col-span-3 text-center">No similar properties found.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    // Share functionality
    function shareProperty(title, text) {
        if (navigator.share) {
            navigator.share({
                title: title,
                text: text,
                url: window.location.href,
            })
            
            .catch((error) => {});
        } else {
            // Fallback for desktop browsers without Web Share API
            const dummy = document.createElement('input'), textUrl = window.location.href;
            document.body.appendChild(dummy);
            dummy.value = textUrl;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            alert('Property link copied to clipboard!');
        }
    }

    // Read More functionality
    document.addEventListener('DOMContentLoaded', function() {
        const readMoreBtn = document.getElementById('readMoreBtn');
        const extendedDescription = document.getElementById('extendedDescription');
        const readMoreIcon = document.getElementById('readMoreIcon');
        
        if (readMoreBtn && extendedDescription) {
            readMoreBtn.addEventListener('click', function() {
                if (extendedDescription.classList.contains('hidden')) {
                    extendedDescription.classList.remove('hidden');
                    readMoreBtn.innerHTML = 'Read Less <svg class="w-4 h-4 ml-1 transform rotate-180 transition-transform" id="readMoreIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
                } else {
                    extendedDescription.classList.add('hidden');
                    readMoreBtn.innerHTML = 'Read More <svg class="w-4 h-4 ml-1 transform transition-transform" id="readMoreIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
                }
            });
        }
    });
</script>
@endsection




