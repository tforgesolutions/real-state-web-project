@extends('layouts.app')

@section('title', 'Notifications | Aura Real Estate')

@section('content')
<div class="pt-24 pb-16 bg-[var(--color-surface)] min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex items-center text-sm text-gray-500 space-x-2 mb-8 animate-fade-up-scroll">
            <a href="{{ route('home') }}" class="hover:text-[var(--color-primary)] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('account.index') }}" class="hover:text-[var(--color-primary)] transition-colors">My Account</a>
            <span>/</span>
            <span class="text-[var(--color-primary)] font-medium">Notifications</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4 animate-fade-up-scroll">
                <x-account.sidebar />
            </div>

            <div class="w-full lg:w-3/4 animate-fade-up-scroll" style="animation-delay: 0.1s;">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden min-h-[600px]">
                    <div class="px-8 py-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center bg-gray-50/50 gap-4">
                        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)] flex items-center">
                            Notifications
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="ml-3 bg-[var(--color-accent)] text-white text-sm px-3 py-1 rounded-full font-bold">{{ auth()->user()->unreadNotifications->count() }} new</span>
                            @endif
                        </h2>
                        
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <form method="POST" action="{{ route('account.notifications.read-all') }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-sm font-bold text-[var(--color-accent)] hover:underline">Mark all as read</button>
                            </form>
                        @endif
                    </div>
                    
                    <div class="p-0">
                        @if(session('status'))
                            <div class="m-8 bg-green-50 text-green-700 p-4 rounded-xl border border-green-100 flex items-center animate-fade-up-scroll">
                                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($notifications->count() > 0)
                            <div class="divide-y divide-gray-100">
                                @foreach($notifications as $notification)
                                    <div class="p-6 sm:p-8 flex items-start gap-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50/30' }} transition-colors group">
                                        <div class="mt-1 flex-shrink-0 w-10 h-10 rounded-full {{ $notification->read_at ? 'bg-gray-100 text-gray-500' : 'bg-blue-100 text-[var(--color-accent)]' }} flex items-center justify-center">
                                            @if(isset($notification->data['type']) && $notification->data['type'] === 'alert')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
                                                <div>
                                                    <h4 class="font-bold text-gray-900 {{ $notification->read_at ? '' : 'text-[var(--color-primary)]' }}">{{ $notification->data['title'] ?? 'Notification' }}</h4>
                                                    <p class="text-sm text-gray-600 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                                                    <span class="text-xs text-gray-400 mt-2 block">{{ $notification->created_at->diffForHumans() }}</span>
                                                </div>
                                                
                                                <div class="flex items-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    @if(is_null($notification->read_at))
                                                        <form method="POST" action="{{ route('account.notifications.read', $notification->id) }}">
                                                            @csrf @method('PATCH')
                                                            <button type="submit" class="text-xs font-medium text-gray-500 hover:text-[var(--color-accent)]" title="Mark as read">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <form method="POST" action="{{ route('account.notifications.destroy', $notification->id) }}">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-xs font-medium text-gray-500 hover:text-red-500" title="Delete">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            
                                            @if(isset($notification->data['link']))
                                                <a href="{{ $notification->data['link'] }}" class="inline-block mt-3 text-sm font-bold text-[var(--color-accent)] hover:underline">View details &rarr;</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="p-6 border-t border-gray-100">
                                {{ $notifications->links() }}
                            </div>
                        @else
                            <div class="text-center py-20 px-8">
                                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                </div>
                                <h3 class="font-heading text-2xl font-bold text-gray-900 mb-2">You're all caught up!</h3>
                                <p class="text-gray-500 max-w-md mx-auto">You don't have any notifications right now. When you get property alerts or messages, they will appear here.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
