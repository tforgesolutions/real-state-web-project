@extends('layouts.app')

@section('title', 'Create Property Alert | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('account.index') }}" class="hover:text-[var(--color-primary)] transition-colors">My Account</a>
            <span>/</span>
            <a href="{{ route('account.alerts.index') }}" class="hover:text-[var(--color-primary)] transition-colors">Alerts</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">Create Alert</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">Create Property Alert</h2>
                        <p class="text-sm text-gray-500 mt-1">Set your search criteria to receive automatic updates.</p>
                    </div>
                    
                    <div class="p-8">
                        @if ($errors->any())
                            <div class="bg-red-50 text-red-500 p-4 rounded-xl text-sm border border-red-100 mb-6">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('account.alerts.store') }}" method="POST" class="space-y-8">
                            @csrf
                            
                            <!-- Alert Details -->
                            <div>
                                <h3 class="font-heading text-lg font-bold text-[var(--color-primary)] mb-4 pb-2 border-b border-gray-100">Alert Details</h3>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Alert Name *</label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]" placeholder="e.g. 3 Bed Houses in Downtown">
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="frequency" class="block text-sm font-semibold text-gray-700 mb-2">Notification Frequency *</label>
                                            <select id="frequency" name="frequency" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                                                <option value="instant" {{ old('frequency') == 'instant' ? 'selected' : '' }}>Instant (As soon as matched)</option>
                                                <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Daily Summary</option>
                                                <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Weekly Summary</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Criteria -->
                            <div>
                                <h3 class="font-heading text-lg font-bold text-[var(--color-primary)] mb-4 pb-2 border-b border-gray-100">Search Criteria</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="transaction_type" class="block text-sm font-semibold text-gray-700 mb-2">Purpose</label>
                                        <select id="transaction_type" name="transaction_type" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                                            <option value="">Any</option>
                                            <option value="buy" {{ old('transaction_type', request('transaction_type')) == 'buy' ? 'selected' : '' }}>Buy</option>
                                            <option value="rent" {{ old('transaction_type', request('transaction_type')) == 'rent' ? 'selected' : '' }}>Rent</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="property_type" class="block text-sm font-semibold text-gray-700 mb-2">Property Type</label>
                                        <select id="property_type" name="property_type" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                                            <option value="">Any</option>
                                            <option value="House" {{ old('property_type', request('property_type')) == 'House' ? 'selected' : '' }}>House</option>
                                            <option value="Apartment" {{ old('property_type', request('property_type')) == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                            <option value="Penthouse" {{ old('property_type', request('property_type')) == 'Penthouse' ? 'selected' : '' }}>Penthouse</option>
                                            <option value="Commercial" {{ old('property_type', request('property_type')) == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                        </select>
                                    </div>
                                    <div class="col-span-1 md:col-span-2">
                                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Location / Area</label>
                                        <input type="text" id="location" name="location" value="{{ old('location', request('location')) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]" placeholder="e.g. Downtown, Marina, etc.">
                                    </div>
                                    
                                    <!-- Price Range -->
                                    <div>
                                        <label for="min_price" class="block text-sm font-semibold text-gray-700 mb-2">Min Price ($)</label>
                                        <input type="number" id="min_price" name="min_price" value="{{ old('min_price', request('min_price')) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                                    </div>
                                    <div>
                                        <label for="max_price" class="block text-sm font-semibold text-gray-700 mb-2">Max Price ($)</label>
                                        <input type="number" id="max_price" name="max_price" value="{{ old('max_price', request('max_price')) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                                    </div>

                                    <!-- Beds/Baths -->
                                    <div>
                                        <label for="min_bedrooms" class="block text-sm font-semibold text-gray-700 mb-2">Min Bedrooms</label>
                                        <input type="number" id="min_bedrooms" name="min_bedrooms" value="{{ old('min_bedrooms', request('min_bedrooms')) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                                    </div>
                                    <div>
                                        <label for="min_bathrooms" class="block text-sm font-semibold text-gray-700 mb-2">Min Bathrooms</label>
                                        <input type="number" id="min_bathrooms" name="min_bathrooms" value="{{ old('min_bathrooms', request('min_bathrooms')) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-gray-100 flex gap-4">
                                <button type="submit" class="btn-primary px-8 py-3 rounded-lg shadow-md font-bold">
                                    Save Alert
                                </button>
                                <a href="{{ route('account.alerts.index') }}" class="px-8 py-3 rounded-lg border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors">
                                    Cancel
                                </a>
                                <button type="reset" class="px-8 py-3 rounded-lg text-gray-500 font-bold hover:text-gray-700 transition-colors ml-auto">
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
