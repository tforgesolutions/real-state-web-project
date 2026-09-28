@extends('layouts.app')

@section('title', 'Reset Password | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-4 sm:px-6 lg:px-8 animate-fade-up-scroll">
        
        <div class="text-center mb-10">
            <a href="/" class="font-heading text-4xl font-bold text-[var(--color-primary)] mb-4 inline-block">
                Aura<span class="text-[var(--color-accent)]">.</span>
            </a>
            <h2 class="font-heading text-2xl font-bold text-gray-900 mt-2">Create New Password</h2>
            <p class="text-gray-500 mt-2">Please enter your new password below.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-2xl border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-[var(--color-accent)]"></div>
            
            <form onsubmit="event.preventDefault(); document.getElementById('successState').classList.remove('hidden'); this.style.display = 'none';" class="space-y-6">
                
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="you@example.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                    <input type="password" id="password" required autofocus class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="••••••••">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="••••••••">
                </div>

                <div>
                    <button type="submit" class="w-full btn-primary py-3 rounded-xl font-bold shadow-md text-lg">
                        Reset Password
                    </button>
                </div>
                
            </form>

            <div id="successState" class="hidden text-center py-4">
                <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Password Reset Successful</h3>
                <p class="text-sm text-gray-500 mb-6">Your password has been changed successfully.</p>
                <a href="{{ route('login') }}" class="btn-primary py-2 px-6 rounded-lg font-bold">Sign In Now</a>
            </div>
        </div>

    </div>
</div>
@endsection
