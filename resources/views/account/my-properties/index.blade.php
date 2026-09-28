@extends('layouts.app')

@section('title', 'My Properties | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('account.index') }}" class="hover:text-[var(--color-primary)] transition-colors">My Account</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">My Properties</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden min-h-[600px]">
                    <div class="px-8 py-6 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center bg-gray-50/50 gap-4">
                        <div>
                            <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">My Properties</h2>
                            <p class="text-sm text-gray-500 mt-1">Manage your property listings, drafts, and monitor their status.</p>
                        </div>
                        <a href="{{ route('properties.create') }}" class="btn-primary py-2 px-6 rounded-lg font-bold shadow-sm whitespace-nowrap text-center flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add Property
                        </a>
                    </div>
                    
                    <!-- Filters -->
                    <div class="border-b border-gray-100 px-8 py-4 flex overflow-x-auto custom-scrollbar space-x-2">
                        @foreach(['all' => 'All', 'draft' => 'Drafts', 'pending_review' => 'Pending Review', 'approved' => 'Approved', 'rejected' => 'Rejected', 'sold' => 'Sold', 'inactive' => 'Inactive'] as $val => $label)
                            <a href="{{ route('account.my-properties.index', ['status' => $val]) }}" class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-colors {{ $status === $val ? 'bg-[var(--color-primary)] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>

                    <div class="p-8">
                        @if(session('success'))
                            <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 border border-green-100 flex items-center animate-fade-up-scroll">
                                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 border border-red-100 flex items-center animate-fade-up-scroll">
                                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($properties->count() > 0)
                            <div class="grid grid-cols-1 gap-6">
                                @foreach($properties as $property)
                                    <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col sm:flex-row gap-6 hover:shadow-md transition-shadow relative overflow-hidden group">
                                        <!-- Status Indicator Line -->
                                        @php
                                            $colorClass = match($property->status) {
                                                'approved' => 'bg-green-500',
                                                'pending_review' => 'bg-yellow-400',
                                                'draft' => 'bg-gray-400',
                                                'rejected' => 'bg-red-500',
                                                default => 'bg-gray-300'
                                            };
                                        @endphp
                                        <div class="absolute top-0 left-0 w-1 h-full {{ $colorClass }}"></div>
                                        
                                        <!-- Image -->
                                        <div class="w-full sm:w-48 h-32 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 relative">
                                            @if($property->images && count($property->images) > 0)
                                                <img src="{{ Storage::url($property->images[0]) }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                                    <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    <span class="text-xs font-semibold">No Image</span>
                                                </div>
                                            @endif
                                            
                                            <!-- Status Badge Over Image -->
                                            <div class="absolute top-2 left-2 px-2 py-1 rounded text-xs font-bold text-white bg-black/60 backdrop-blur-sm uppercase tracking-wide">
                                                {{ str_replace('_', ' ', $property->status) }}
                                            </div>
                                        </div>
                                        
                                        <!-- Details -->
                                        <div class="flex-1 flex flex-col justify-between">
                                            <div>
                                                <div class="flex justify-between items-start mb-1">
                                                    <h3 class="font-bold text-lg text-gray-900 group-hover:text-[var(--color-accent)] transition-colors truncate max-w-[200px] sm:max-w-md" title="{{ $property->title }}">
                                                        {{ $property->title }}
                                                    </h3>
                                                    <span class="font-bold text-[var(--color-primary)] whitespace-nowrap ml-2">
                                                        {{ $property->price_unit ?? '$' }}{{ number_format($property->price) }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-500 mb-3 flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                    {{ $property->city }}, {{ $property->country ?? 'Unknown' }}
                                                </p>
                                                <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs font-medium text-gray-500">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                                        ID: {{ $property->reference_id }}
                                                    </span>
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        Updated: {{ $property->updated_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Actions -->
                                            <div class="flex items-center gap-3 mt-4 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                                                <a href="{{ route('account.my-properties.edit', $property) }}" class="text-sm font-semibold text-[var(--color-primary)] hover:text-[var(--color-accent)] transition-colors flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    Edit
                                                </a>
                                                
                                                @if($property->status === 'approved')
                                                    <a href="{{ route('properties.show', $property->slug) }}" target="_blank" class="text-sm font-semibold text-gray-500 hover:text-[var(--color-primary)] transition-colors flex items-center ml-2">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                        View Live
                                                    </a>
                                                @endif
                                                
                                                <div class="ml-auto">
                                                    <form action="{{ route('account.my-properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Are you sure you want to withdraw/delete this property?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-sm font-semibold text-red-500 hover:text-red-700 transition-colors flex items-center bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            Withdraw
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-8">
                                {{ $properties->links() }}
                            </div>
                        @else
                            <div class="text-center py-16 bg-gray-50 rounded-xl border border-gray-100 border-dashed">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-2">No Properties Found</h3>
                                <p class="text-gray-500 max-w-sm mx-auto mb-6">You haven't listed any properties matching this status yet.</p>
                                <a href="{{ route('properties.create') }}" class="btn-primary px-6 py-2.5 rounded-lg inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    Create Your First Listing
                                </a>
                            </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
