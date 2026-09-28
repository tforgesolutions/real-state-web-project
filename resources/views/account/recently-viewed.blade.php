@extends('layouts.app')

@section('title', 'Recently Viewed | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('account.index') }}" class="hover:text-[var(--color-primary)] transition-colors">My Account</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">Recently Viewed</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden min-h-[600px]">
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] flex items-center">
                            Recently Viewed
                        </h2>
                    </div>
                    
                    <div class="p-8">
                        
                        <!-- Empty State (No recently viewed logic yet) -->
                        <div class="text-center py-20">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-3">No recent history</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">Properties you view will appear here so you can easily find them later.</p>
                            <a href="{{ route('properties.index') }}" class="btn-primary py-3 px-8 rounded-xl font-bold shadow-md inline-block">Explore Properties</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
