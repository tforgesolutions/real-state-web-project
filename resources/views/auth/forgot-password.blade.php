@extends('layouts.app')

@section('title', 'Forgot Password | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-4 sm:px-6 lg:px-8 animate-fade-up-scroll">
        
        <div class="text-center mb-10">
            <a href="/" class="font-heading text-4xl font-bold text-[var(--color-primary)] mb-4 inline-block">
                Aura<span class="text-[var(--color-accent)]">.</span>
            </a>
            <h2 class="font-heading text-2xl font-bold text-gray-900 mt-2">Reset Password</h2>
            <p class="text-gray-500 mt-2">Enter your email and we'll send you a link to reset your password.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-2xl border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-[var(--color-accent)]"></div>
            
            <form onsubmit="event.preventDefault(); document.getElementById('successState').classList.remove('hidden'); this.style.display = 'none';" class="space-y-6">
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" required autofocus class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="you@example.com">
                </div>

                <div>
                    <button type="submit" class="w-full btn-primary py-3 rounded-xl font-bold shadow-md text-lg">
                        Send Reset Link
                    </button>
                </div>
                
            </form>

            <div id="successState" class="hidden text-center py-4">
                <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Check your email</h3>
                <p class="text-sm text-gray-500">We have sent a password reset link to your email address.</p>
                <a href="{{ route('password.reset', ['token' => 'demo-token']) }}" class="mt-4 inline-block text-sm font-bold text-[var(--color-accent)] hover:underline">Demo: Proceed to Reset UI &rarr;</a>
            </div>
        </div>

        <p class="text-center text-sm text-gray-600 mt-8">
            Remember your password? 
            <a href="{{ route('login') }}" class="font-bold text-[var(--color-primary)] hover:text-[var(--color-accent)] transition-colors">Sign in</a>
        </p>

    </div>
</div>
@endsection
