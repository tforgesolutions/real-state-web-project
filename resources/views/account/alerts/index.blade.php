@extends('layouts.app')

@section('title', 'Property Alerts | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('account.index') }}" class="hover:text-[var(--color-primary)] transition-colors">My Account</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">Property Alerts</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden min-h-[600px]">
                    <div class="px-8 py-6 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center bg-gray-50/50 gap-4">
                        <div>
                            <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">Property Alerts</h2>
                            <p class="text-sm text-gray-500 mt-1">Get notified when new properties match your criteria.</p>
                        </div>
                        <a href="{{ route('account.alerts.create') }}" class="btn-primary py-2 px-6 rounded-lg font-bold shadow-sm whitespace-nowrap text-center">
                            + Create Alert
                        </a>
                    </div>
                    
                    <div class="p-8">
                        @if(session('status'))
                            <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 border border-green-100 flex items-center animate-fade-up-scroll">
                                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($alerts->count() > 0)
                            <div class="grid grid-cols-1 gap-6">
                                @foreach($alerts as $alert)
                                    <div class="bg-white border {{ $alert->status === 'active' ? 'border-gray-200 shadow-sm' : 'border-gray-200 bg-gray-50 opacity-75' }} rounded-xl p-6 transition-all group relative overflow-hidden">
                                        @if($alert->status === 'active')
                                            <div class="absolute top-0 left-0 w-1 h-full bg-green-500"></div>
                                        @else
                                            <div class="absolute top-0 left-0 w-1 h-full bg-gray-400"></div>
                                        @endif

                                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                            <div>
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <h3 class="font-bold text-lg text-gray-900">{{ $alert->name }}</h3>
                                                    @if($alert->status === 'active')
                                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full font-semibold">Active</span>
                                                    @else
                                                        <span class="bg-gray-200 text-gray-800 text-xs px-2 py-0.5 rounded-full font-semibold">Paused</span>
                                                    @endif
                                                </div>
                                                
                                                <div class="text-sm text-gray-600 space-y-1">
                                                    @if($alert->transaction_type || $alert->property_type)
                                                        <p><span class="font-medium">Type:</span> {{ ucfirst($alert->transaction_type) }} {{ $alert->property_type }}</p>
                                                    @endif
                                                    @if($alert->location)
                                                        <p><span class="font-medium">Location:</span> {{ $alert->location }}</p>
                                                    @endif
                                                    @if($alert->min_price || $alert->max_price)
                                                        <p><span class="font-medium">Price:</span> 
                                                            {{ $alert->min_price ? '$' . number_format($alert->min_price) : 'Any' }} - 
                                                            {{ $alert->max_price ? '$' . number_format($alert->max_price) : 'Any' }}
                                                        </p>
                                                    @endif
                                                    <p><span class="font-medium">Frequency:</span> {{ ucfirst($alert->frequency) }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center space-x-2 w-full md:w-auto">
                                                <form action="{{ route('account.alerts.status', $alert) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm font-medium {{ $alert->status === 'active' ? 'text-gray-600 hover:bg-gray-100' : 'text-green-600 hover:bg-green-50 border-green-200' }} transition-colors w-full md:w-auto">
                                                        {{ $alert->status === 'active' ? 'Pause' : 'Resume' }}
                                                    </button>
                                                </form>
                                                
                                                <a href="{{ route('account.alerts.edit', $alert) }}" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors w-full md:w-auto text-center">Edit</a>
                                                
                                                <form action="{{ route('account.alerts.destroy', $alert) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this alert?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 border border-red-200 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors w-full md:w-auto">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-[var(--color-primary)]">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                </div>
                                <h3 class="font-heading text-2xl font-bold text-gray-900 mb-2">No Active Alerts</h3>
                                <p class="text-gray-500 mb-8 max-w-md mx-auto">Create property alerts to stay updated on the latest listings that match your criteria.</p>
                                <a href="{{ route('account.alerts.create') }}" class="btn-primary py-3 px-8 rounded-xl font-bold inline-block">Create Your First Alert</a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
