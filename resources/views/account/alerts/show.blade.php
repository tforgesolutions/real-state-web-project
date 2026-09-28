@extends('layouts.app')

@section('title', $alert->name . ' | Property Alert | Aura Real Estate')

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
            <span class="text-[var(--color-primary)] font-medium">{{ Str::limit($alert->name, 20) }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="px-8 py-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gray-50/50 gap-4">
                        <div>
                            <div class="flex items-center space-x-3 mb-1">
                                <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">{{ $alert->name }}</h2>
                                @if($alert->status === 'active')
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full font-semibold">Active</span>
                                @else
                                    <span class="bg-gray-200 text-gray-800 text-xs px-2 py-0.5 rounded-full font-semibold">Paused</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500">Created on {{ $alert->created_at->format('M d, Y') }} &bull; Last updated {{ $alert->updated_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('account.alerts.edit', $alert) }}" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">Edit Alert</a>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <h3 class="font-bold text-lg text-[var(--color-primary)] mb-4 pb-2 border-b border-gray-100">Alert Configuration</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Notification Frequency</span>
                                <span class="font-medium text-gray-900">{{ ucfirst($alert->frequency) }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Last Notified</span>
                                <span class="font-medium text-gray-900">{{ $alert->last_notified_at ? $alert->last_notified_at->diffForHumans() : 'Never' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Transaction Type</span>
                                <span class="font-medium text-gray-900">{{ $alert->transaction_type ? ucfirst($alert->transaction_type) : 'Any' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Property Type</span>
                                <span class="font-medium text-gray-900">{{ $alert->property_type ?? 'Any' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Location</span>
                                <span class="font-medium text-gray-900">{{ $alert->location ?? 'Any' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Price Range</span>
                                <span class="font-medium text-gray-900">
                                    {{ $alert->min_price ? '$' . number_format($alert->min_price) : 'Any' }} - 
                                    {{ $alert->max_price ? '$' . number_format($alert->max_price) : 'Any' }}
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Bedrooms</span>
                                <span class="font-medium text-gray-900">
                                    {{ $alert->min_bedrooms ?? 'Any' }} - {{ $alert->max_bedrooms ?? 'Any' }}
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Bathrooms</span>
                                <span class="font-medium text-gray-900">
                                    {{ $alert->min_bathrooms ?? 'Any' }} - {{ $alert->max_bathrooms ?? 'Any' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden min-h-[300px]">
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-heading text-xl font-bold text-[var(--color-primary)]">Matching Properties</h3>
                    </div>
                    <div class="p-8 text-center py-16">
                        <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Monitoring Active</h4>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto">We are monitoring the market for properties matching your criteria. As soon as a match is found, it will appear here and you will be notified.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
