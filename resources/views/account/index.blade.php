@extends('layouts.app')

@section('title', 'My Account | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">My Account</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar -->
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <!-- Main Content -->
            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <h1 class="font-heading text-3xl font-bold text-[var(--color-primary)] mb-8">Welcome back, {{ auth()->user()->name }}!</h1>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center group hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-red-50 text-red-500 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Saved Properties</p>
                            <h3 class="text-2xl font-bold text-[var(--color-primary)]" id="dashFavCount">0</h3>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center group hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Active Inquiries</p>
                            <h3 class="text-2xl font-bold text-[var(--color-primary)]">0</h3>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center group hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-gray-50 text-gray-500 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Recently Viewed</p>
                            <h3 class="text-2xl font-bold text-[var(--color-primary)]" id="dashViewCount">0</h3>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Placeholder -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                        <h3 class="font-heading text-xl font-bold text-[var(--color-primary)]">Recent Activity</h3>
                    </div>
                    
                    <div class="text-center py-10">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-gray-500 font-medium">No recent activity</p>
                        <p class="text-sm text-gray-400 mt-1">Start exploring properties to see your activity here.</p>
                        <a href="{{ route('properties.index') }}" class="btn-primary mt-6 px-6 py-2 rounded-lg inline-block">Explore Properties</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            if(window.AuraFavorites) {
                document.getElementById('dashFavCount').innerText = window.AuraFavorites.get().length;
            }
        }, 100);
    });
</script>
@endsection
