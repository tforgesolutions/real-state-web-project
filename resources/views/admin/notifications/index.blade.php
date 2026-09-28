@extends('admin.layouts.app')

@section('title', 'Notifications')
@section('header', 'Notifications')

@section('content')

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded shadow-sm">
    <div class="flex items-center">
        <i class="fas fa-check-circle text-green-500 mr-3"></i>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
        <h2 class="font-semibold text-gray-800">All Notifications</h2>
        @if(auth()->user()->unreadNotifications->count() > 0)
        <form action="{{ route('admin.notifications.markAllAsRead') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-check-double mr-1"></i> Mark all as read
            </button>
        </form>
        @endif
    </div>

    <ul class="divide-y divide-gray-100">
        @forelse($notifications as $notification)
        <li class="{{ $notification->read_at ? 'bg-white' : 'bg-blue-50/30' }} hover:bg-gray-50 transition-colors">
            <div class="px-6 py-5 flex items-start justify-between">
                <div class="flex items-start flex-1 min-w-0">
                    <div class="flex-shrink-0 pt-1">
                        @if($notification->read_at)
                            <i class="fas fa-envelope-open text-gray-400 text-lg"></i>
                        @else
                            <i class="fas fa-envelope text-blue-500 text-lg"></i>
                        @endif
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium {{ $notification->read_at ? 'text-gray-900' : 'text-blue-900 font-bold' }}">
                                {{ $notification->data['type'] ?? 'Notification' }}
                            </p>
                            <p class="text-xs text-gray-500 whitespace-nowrap ml-4">
                                {{ $notification->created_at->format('M d, Y g:i A') }} ({{ $notification->created_at->diffForHumans() }})
                            </p>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">
                            <strong>{{ $notification->data['name'] ?? 'System' }}</strong>: 
                            {{ $notification->data['message'] ?? 'No details provided.' }}
                        </p>
                        @if(isset($notification->data['inquiry_id']))
                        <div class="mt-3">
                            <a href="{{ route('admin.notifications.read', $notification->id) }}" class="inline-flex items-center text-xs font-medium text-blue-600 hover:text-blue-800">
                                View Inquiry <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="ml-6 flex-shrink-0 flex items-center space-x-2">
                    @if($notification->read_at)
                    <form action="{{ route('admin.notifications.unread', $notification->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-blue-600 text-xs font-medium" title="Mark as unread">
                            <i class="fas fa-circle"></i>
                        </button>
                    </form>
                    @else
                    <a href="{{ route('admin.notifications.read', $notification->id) }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium" title="Mark as read">
                        <i class="far fa-circle"></i>
                    </a>
                    @endif
                </div>
            </div>
        </li>
        @empty
        <li class="px-6 py-12 text-center">
            <i class="far fa-bell-slash text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-500 font-medium">You have no notifications.</p>
        </li>
        @endforelse
    </ul>
    
    @if($notifications->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $notifications->links() }}
    </div>
    @endif
</div>

@endsection
