@extends('layouts.app')

@section('title', 'Property Submitted | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen flex items-center justify-center">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 w-full animate-fade-up-scroll">
        <div class="bg-white border border-gray-100 rounded-3xl p-10 text-center shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-green-50 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 -z-10"></div>
            
            <div class="w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-sm">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h1 class="font-heading text-3xl md:text-4xl font-bold text-[var(--color-primary)] mb-4">Property Submitted!</h1>
            
            <p class="text-gray-600 text-lg mb-8">Thank you for listing with Aura. Your property has been successfully submitted and is currently <strong>{{ $property->status === 'draft' ? 'saved as a draft' : 'under review' }}</strong>.</p>
            
            <div class="bg-gray-50 rounded-2xl p-6 text-left mb-8 border border-gray-100">
                <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                    <span class="text-gray-500 font-medium">Reference ID</span>
                    <span class="font-bold text-[var(--color-primary)]">{{ $property->reference_id }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                    <span class="text-gray-500 font-medium">Title</span>
                    <span class="font-semibold text-gray-900 truncate max-w-[200px]" title="{{ $property->title }}">{{ $property->title }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 font-medium">Status</span>
                    @if($property->status === 'draft')
                        <span class="bg-gray-200 text-gray-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Draft</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Pending Review</span>
                    @endif
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('account.my-properties.index') }}" class="btn-primary px-8 py-3 rounded-xl font-bold text-lg shadow-md hover:shadow-lg transition-all w-full sm:w-auto">
                    Manage Properties
                </a>
                <a href="{{ route('home') }}" class="px-8 py-3 rounded-xl font-bold text-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors w-full sm:w-auto">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
