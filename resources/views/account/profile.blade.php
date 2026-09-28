@extends('layouts.app')

@section('title', 'My Profile | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('account.index') }}" class="hover:text-[var(--color-primary)] transition-colors">My Account</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">My Profile</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">My Profile</h2>
                    </div>
                    
                    <div class="p-8">
                        @if(session('status'))
                            <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 border border-green-100 flex items-center animate-fade-up-scroll">
                                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('account.profile.update') }}" class="space-y-6">
                            @csrf
                            
                            <!-- Profile Photo (UI only) -->
                            <div class="flex items-center space-x-6 mb-8">
                                <div class="w-24 h-24 bg-gray-200 rounded-full overflow-hidden border-2 border-gray-100">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <button type="button" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors border border-gray-200 mb-2 block">Change Photo</button>
                                    <p class="text-xs text-gray-500">JPG, GIF or PNG. Max size of 2MB.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="+1 (234) 567-8900">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Preferred Contact Method</label>
                                    <select class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors">
                                        <option>Email</option>
                                        <option>Phone Call</option>
                                        <option>WhatsApp</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-gray-100 flex gap-4">
                                <button type="submit" class="btn-primary px-8 py-3 rounded-lg shadow-md font-bold">
                                    Save Changes
                                </button>
                                <a href="{{ route('account.index') }}" class="px-8 py-3 rounded-lg border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
