@extends('layouts.app')

@section('title', 'My Inquiries | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('account.index') }}" class="hover:text-[var(--color-primary)] transition-colors">My Account</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">My Inquiries</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden min-h-[600px]">
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] flex items-center">
                            Inquiry History <span class="ml-3 bg-gray-200 text-gray-600 text-sm px-3 py-1 rounded-full font-bold">0</span>
                        </h2>
                    </div>
                    
                    <div class="p-8">
                        
                        <!-- Empty State (No database logic yet) -->
                        <div class="text-center py-20">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            </div>
                            <h3 class="font-heading text-2xl font-bold text-[var(--color-primary)] mb-3">No inquiries yet</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">You haven't sent any inquiries to agents or property owners yet.</p>
                            <a href="{{ route('properties.index') }}" class="btn-primary py-3 px-8 rounded-xl font-bold shadow-md inline-block">Explore Properties</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
