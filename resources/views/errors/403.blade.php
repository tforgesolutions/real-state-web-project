@extends('layouts.app')

@section('title', 'Unauthorized | Aura Real Estate')

@section('content')
<div class="pt-32 pb-24 bg-[var(--color-surface)] min-h-[80vh] flex items-center justify-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-up-scroll">
        <div class="text-[var(--color-primary)] font-heading font-black text-9xl tracking-tighter mb-4 opacity-10">403</div>
        <h1 class="font-heading text-4xl md:text-5xl font-bold text-[var(--color-primary)] mb-6 -mt-20">Access Denied</h1>
        <p class="text-gray-600 text-lg md:text-xl mb-10 max-w-xl mx-auto">You don't have permission to access this resource. Please make sure you are logged in with the correct account.</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            @guest
                <a href="{{ route('login') }}" class="btn-primary px-8 py-3 rounded-lg text-lg w-full sm:w-auto text-center">
                    Log In
                </a>
            @endguest
            <a href="{{ route('home') }}" class="px-8 py-3 rounded-lg text-lg font-bold border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors w-full sm:w-auto text-center">
                Return Home
            </a>
        </div>
    </div>
</div>
@endsection
