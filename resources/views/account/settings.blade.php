@extends('layouts.app')

@section('title', 'Account Settings | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('account.index') }}" class="hover:text-[var(--color-primary)] transition-colors">My Account</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">Account Settings</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">Settings & Preferences</h2>
                    </div>
                    
                    <div class="p-8">

                        <form class="space-y-10" onsubmit="event.preventDefault(); alert('Settings saved successfully! (Frontend demo)');">
                            
                            <!-- PREFERENCES -->
                            <div>
                                <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-4 border-b border-gray-100 pb-2">Preferences</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Preferred Transaction</label>
                                        <select class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-colors">
                                            <option>Buying</option>
                                            <option>Renting</option>
                                            <option>Investing</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Preferred Property Type</label>
                                        <select class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-colors">
                                            <option>Apartments / Flats</option>
                                            <option>Houses / Villas</option>
                                            <option>Penthouses</option>
                                            <option>Commercial Spaces</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- NOTIFICATIONS -->
                            <div>
                                <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-4 border-b border-gray-100 pb-2">Notifications</h3>
                                <div class="space-y-4 mt-4">
                                    <label class="flex items-start">
                                        <input type="checkbox" checked class="mt-1 mr-3 text-[var(--color-accent)] focus:ring-[var(--color-accent)] border-gray-300 rounded">
                                        <div>
                                            <span class="block text-sm font-bold text-gray-900">Email Notifications</span>
                                            <span class="block text-xs text-gray-500 mt-1">Receive general platform updates and announcements.</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start">
                                        <input type="checkbox" checked class="mt-1 mr-3 text-[var(--color-accent)] focus:ring-[var(--color-accent)] border-gray-300 rounded">
                                        <div>
                                            <span class="block text-sm font-bold text-gray-900">Property Alerts</span>
                                            <span class="block text-xs text-gray-500 mt-1">Get notified when properties matching your preferences are listed.</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start">
                                        <input type="checkbox" checked class="mt-1 mr-3 text-[var(--color-accent)] focus:ring-[var(--color-accent)] border-gray-300 rounded">
                                        <div>
                                            <span class="block text-sm font-bold text-gray-900">Inquiry Updates</span>
                                            <span class="block text-xs text-gray-500 mt-1">Receive email alerts when agents respond to your inquiries.</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start">
                                        <input type="checkbox" class="mt-1 mr-3 text-[var(--color-accent)] focus:ring-[var(--color-accent)] border-gray-300 rounded">
                                        <div>
                                            <span class="block text-sm font-bold text-gray-900">Weekly Newsletter</span>
                                            <span class="block text-xs text-gray-500 mt-1">Market insights, trends, and featured properties every week.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- SECURITY -->
                            <div>
                                <h3 class="font-heading text-xl font-bold text-[var(--color-primary)] mb-4 border-b border-gray-100 pb-2">Security</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                                        <input type="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-colors" placeholder="••••••••">
                                    </div>
                                    <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                                            <input type="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-colors" placeholder="••••••••">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                                            <input type="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition-colors" placeholder="••••••••">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-gray-100">
                                <button type="submit" class="btn-primary px-8 py-3 rounded-lg shadow-md font-bold">
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- DANGER ZONE -->
                <div class="bg-red-50 rounded-2xl shadow-sm border border-red-100 overflow-hidden mt-8 animate-fade-up-scroll" style="animation-delay: 0.2s;">
                    <div class="p-8">
                        <h3 class="font-heading text-xl font-bold text-red-600 mb-2">Delete Account</h3>
                        <p class="text-sm text-red-500 mb-6">Permanently delete your account and all associated data. This action cannot be undone.</p>
                        <button onclick="alert('Account deletion UI placeholder. Backend not implemented yet.')" class="px-6 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                            Delete My Account
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
