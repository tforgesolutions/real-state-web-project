@extends('admin.layouts.app')

@section('title', $module)
@section('header', $module)

@section('content')
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
        <i class="fas fa-tools text-5xl text-gray-300 mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $module }} Module</h2>
        <p class="text-gray-500 max-w-md mx-auto">This module is part of the Admin Panel foundation but has not yet been fully implemented. It will be built in a future phase.</p>
        
        <div class="mt-8">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </div>
@endsection
