@extends('layouts.app')

@section('title', 'Server Error | Aura Real Estate')

@section('content')
<div class="pt-32 pb-24 bg-[var(--color-surface)] min-h-[80vh] flex items-center justify-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-up-scroll">
        <div class="text-[var(--color-primary)] font-heading font-black text-9xl tracking-tighter mb-4 opacity-10">500</div>
        <h1 class="font-heading text-4xl md:text-5xl font-bold text-[var(--color-primary)] mb-6 -mt-20">Server Error</h1>
        <p class="text-gray-600 text-lg md:text-xl mb-10 max-w-xl mx-auto">Oops, something went wrong on our end. We are actively working to fix the issue. Please try again later.</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button onclick="window.location.reload();" class="btn-primary px-8 py-3 rounded-lg text-lg w-full sm:w-auto text-center">
                Try Again
            </button>
            <a href="{{ route('home') }}" class="px-8 py-3 rounded-lg text-lg font-bold border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors w-full sm:w-auto text-center">
                Return Home
            </a>
        </div>
    </div>
</div>
@endsection
