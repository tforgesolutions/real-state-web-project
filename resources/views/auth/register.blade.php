@extends('layouts.app')

@section('title', 'Create Account | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen flex items-center justify-center">
    <div class="max-w-xl w-full px-4 sm:px-6 lg:px-8 animate-fade-up-scroll">
        
        <div class="text-center mb-10">
            <a href="/" class="font-heading text-4xl font-bold text-[var(--color-primary)] mb-4 inline-block">
                Aura<span class="text-[var(--color-accent)]">.</span>
            </a>
            <h2 class="font-heading text-2xl font-bold text-gray-900 mt-2">Create an account</h2>
            <p class="text-gray-500 mt-2">Join Aura to save properties, compare options, and connect with agents.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-2xl border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-[var(--color-accent)]"></div>
            
            <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 p-4 rounded-xl text-sm border border-red-100 flex items-start">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="John Doe">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="+1 (234) 567-8900">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input type="password" id="password" name="password" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="••••••••">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-start">
                    <input type="checkbox" id="terms" name="terms" required class="mt-1 h-4 w-4 text-[var(--color-accent)] focus:ring-[var(--color-accent)] border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-600">
                        I agree to the <a href="#" class="text-[var(--color-accent)] hover:underline font-medium">Terms & Conditions</a> and <a href="#" class="text-[var(--color-accent)] hover:underline font-medium">Privacy Policy</a>.
                    </label>
                </div>

                <div>
                    <button type="submit" class="w-full btn-primary py-4 rounded-xl font-bold shadow-md text-lg">
                        Create Account
                    </button>
                </div>
                
            </form>
        </div>

        <p class="text-center text-sm text-gray-600 mt-8">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-[var(--color-primary)] hover:text-[var(--color-accent)] transition-colors">Sign in</a>
        </p>

    </div>
</div>
@endsection
