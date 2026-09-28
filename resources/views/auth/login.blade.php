@extends('layouts.app')

@section('title', 'Sign In | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-4 sm:px-6 lg:px-8 animate-fade-up-scroll">
        
        <div class="text-center mb-10">
            <a href="/" class="font-heading text-4xl font-bold text-[var(--color-primary)] mb-4 inline-block">
                Aura<span class="text-[var(--color-accent)]">.</span>
            </a>
            <h2 class="font-heading text-2xl font-bold text-gray-900 mt-2">Welcome back</h2>
            <p class="text-gray-500 mt-2">Sign in to your account to continue</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-2xl border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-[var(--color-accent)]"></div>
            
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
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
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="you@example.com">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-[var(--color-accent)] hover:underline tabindex='-1'">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] focus:bg-white transition-colors" placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-[var(--color-accent)] focus:ring-[var(--color-accent)] border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-600">
                        Remember me
                    </label>
                </div>

                <div>
                    <button type="submit" class="w-full btn-primary py-3 rounded-xl font-bold shadow-md text-lg">
                        Sign In
                    </button>
                </div>
                
            </form>
        </div>

        <p class="text-center text-sm text-gray-600 mt-8">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-[var(--color-primary)] hover:text-[var(--color-accent)] transition-colors">Create an account</a>
        </p>

    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    }
</script>
@endsection
