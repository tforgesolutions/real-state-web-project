@extends('admin.layouts.app')

@section('title', 'View User')
@section('header', 'View User Profile')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Users
    </a>
    <div class="space-x-2 flex">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
            <i class="fas fa-edit mr-2"></i> Edit User
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Left Column: Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 flex flex-col items-center border-b border-gray-100">
                <div class="h-32 w-32 rounded-full overflow-hidden bg-gray-100 border-4 border-white shadow-lg mb-4">
                    @if($user->profile_photo)
                        <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-gray-500 font-bold text-4xl bg-indigo-100 text-indigo-600">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-gray-900 text-center">{{ $user->name }}</h2>
                <p class="text-gray-500 text-sm text-center mb-3">ID: {{ $user->id }}</p>
                
                <div class="flex items-center gap-2 mb-4">
                    @php
                        $roleColors = [
                            'admin' => 'bg-purple-100 text-purple-800',
                            'agent' => 'bg-blue-100 text-blue-800',
                            'user' => 'bg-gray-100 text-gray-800',
                        ];
                        $rcolor = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2.5 py-0.5 rounded-md text-xs font-medium capitalize {{ $rcolor }}">
                        <i class="fas fa-shield-alt mr-1"></i> {{ $user->role }}
                    </span>
                    
                    @php
                        $statusColors = [
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-gray-100 text-gray-800',
                            'suspended' => 'bg-red-100 text-red-800',
                        ];
                        $color = $statusColors[$user->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $color }}">
                        {{ $user->status }}
                    </span>
                </div>
            </div>

            <div class="p-6 bg-gray-50 space-y-4">
                <div>
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Contact Details</h4>
                    <p class="text-sm text-gray-800 flex items-center"><i class="fas fa-envelope w-5 text-gray-400"></i> <a href="mailto:{{ $user->email }}" class="hover:text-blue-600">{{ $user->email }}</a></p>
                    <p class="text-sm text-gray-800 mt-2 flex items-center"><i class="fas fa-phone w-5 text-gray-400"></i> {{ $user->phone ?? 'Not provided' }}</p>
                </div>
                <hr class="border-gray-200">
                <div>
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Location</h4>
                    <p class="text-sm text-gray-800 flex items-start">
                        <i class="fas fa-map-marker-alt w-5 text-gray-400 mt-1"></i> 
                        <span>
                            {{ $user->address ? $user->address . ',' : '' }}<br>
                            {{ $user->city ? $user->city . ',' : '' }} {{ $user->country }}
                            @if(!$user->address && !$user->city && !$user->country)
                                Not provided
                            @endif
                        </span>
                    </p>
                </div>
            </div>
            <div class="bg-white border-t border-gray-100 px-6 py-4 text-xs text-gray-500 flex justify-between">
                <span>Registered:</span>
                <span class="font-medium text-gray-700">{{ $user->created_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>
    </div>

    <!-- Right Column: Activity & Related Data -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-envelope-open-text text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Inquiries</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="p-3 rounded-full bg-pink-100 text-pink-600 mr-4">
                    <i class="fas fa-heart text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Saved Properties</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Reviews</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->reviews()->count() }}</p>
                </div>
            </div>
        </div>

        @if($user->role === 'agent' || $user->role === 'admin')
        <!-- Agent Properties (If applicable) -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Assigned Properties</h3>
                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-blue-800 bg-blue-100 rounded-full">{{ $user->properties()->count() }}</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($user->properties()->latest()->take(5)->get() as $property)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($property->title, 40) }}</div>
                                <div class="text-xs text-gray-500">${{ number_format($property->price) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 capitalize">
                                    {{ str_replace('_', ' ', $property->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.properties.show', $property->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded" title="View Property"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-building text-3xl mb-3 text-gray-200"></i>
                                <p class="text-sm">No properties assigned.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($user->properties()->count() > 5)
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 text-center">
                <a href="{{ route('admin.properties.index', ['agent' => $user->id]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">View All Properties</a>
            </div>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection
