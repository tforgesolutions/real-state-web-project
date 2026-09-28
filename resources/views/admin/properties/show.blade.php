@extends('admin.layouts.app')

@section('title', 'View Property')
@section('header', 'View Property')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.properties.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Properties
    </a>
    <div class="space-x-2 flex">
        <a href="{{ route('admin.properties.edit', $property->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
            <i class="fas fa-edit mr-2"></i> Edit
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
        <!-- Property Images -->
        <div class="lg:col-span-1 border-b lg:border-b-0 lg:border-r border-gray-100 p-6 bg-gray-50 flex flex-col items-center">
            @if(!empty($property->images) && count($property->images) > 0)
                <img src="{{ Storage::url($property->images[0]) }}" alt="{{ $property->title }}" class="w-full h-64 object-cover rounded-lg shadow-sm mb-4">
                <div class="grid grid-cols-4 gap-2 w-full">
                    @foreach(array_slice($property->images, 1, 4) as $img)
                        <img src="{{ Storage::url($img) }}" class="w-full h-16 object-cover rounded-md opacity-80 hover:opacity-100 cursor-pointer border border-gray-200">
                    @endforeach
                </div>
            @else
                <div class="w-full h-64 bg-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-400 mb-4 shadow-sm">
                    <i class="fas fa-image text-5xl mb-2"></i>
                    <span>No images available</span>
                </div>
            @endif

            <div class="w-full mt-6 space-y-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Agent / Owner Info</h4>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg">
                            {{ substr($property->user->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $property->user->name ?? 'Unknown' }}</p>
                            <p class="text-xs text-gray-500">{{ $property->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Contact Info</h4>
                    <p class="text-sm text-gray-800"><i class="fas fa-user w-5 text-gray-400"></i> {{ $property->contact_name }}</p>
                    <p class="text-sm text-gray-800 mt-1"><i class="fas fa-phone w-5 text-gray-400"></i> {{ $property->contact_phone }}</p>
                    <p class="text-sm text-gray-800 mt-1"><i class="fas fa-envelope w-5 text-gray-400"></i> {{ $property->contact_email }}</p>
                </div>
            </div>
        </div>

        <!-- Property Details -->
        <div class="lg:col-span-2 p-6 md:p-8">
            <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-100 text-gray-800',
                                'pending_review' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'sold' => 'bg-blue-100 text-blue-800',
                                'rented' => 'bg-purple-100 text-purple-800',
                                'inactive' => 'bg-red-100 text-red-800',
                            ];
                            $color = $statusColors[$property->status] ?? 'bg-gray-100 text-gray-800';
                            $label = str_replace('_', ' ', $property->status);
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $color }}">
                            {{ $label }}
                        </span>
                        
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $property->purpose === 'buy' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                            For {{ $property->purpose === 'buy' ? 'Sale' : 'Rent' }}
                        </span>
                        
                        @if($property->is_featured)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 flex items-center">
                                <i class="fas fa-star text-[10px] mr-1"></i> Featured
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $property->title }}</h1>
                    <p class="text-gray-500 text-sm flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i> 
                        {{ $property->address ? $property->address . ', ' : '' }}
                        {{ $property->area_locality }}, {{ $property->city }}
                    </p>
                </div>
                
                <div class="text-right">
                    <p class="text-3xl font-bold text-blue-600">${{ number_format($property->price) }}</p>
                    <p class="text-sm text-gray-500">ID: {{ $property->reference_id }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-8">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Property Type</p>
                    <p class="font-medium text-gray-900"><i class="fas fa-home text-blue-500 mr-2"></i>{{ $property->property_type }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Area Size</p>
                    <p class="font-medium text-gray-900"><i class="fas fa-vector-square text-blue-500 mr-2"></i>{{ $property->area }} {{ $property->area_unit }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Bedrooms</p>
                    <p class="font-medium text-gray-900"><i class="fas fa-bed text-blue-500 mr-2"></i>{{ $property->bedrooms ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Bathrooms</p>
                    <p class="font-medium text-gray-900"><i class="fas fa-bath text-blue-500 mr-2"></i>{{ $property->bathrooms ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="mb-8 border-t border-gray-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                <div class="text-gray-700 whitespace-pre-line text-sm leading-relaxed">
                    {{ $property->description ?: 'No description provided.' }}
                </div>
            </div>

            <div class="mb-2 border-t border-gray-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Amenities</h3>
                @if($property->amenitiesRelation && $property->amenitiesRelation->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-3 gap-x-4">
                        @foreach($property->amenitiesRelation as $amenity)
                            <div class="flex items-center text-gray-700 text-sm">
                                <i class="{{ $amenity->icon ?? 'fas fa-check' }} text-blue-500 mr-2 w-5"></i> {{ $amenity->name }}
                            </div>
                        @endforeach
                    </div>
                @elseif(!empty($property->amenities) && is_array($property->amenities) && count($property->amenities) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-3 gap-x-4">
                        @foreach($property->amenities as $amenity)
                            <div class="flex items-center text-gray-700 text-sm">
                                <i class="fas fa-check text-green-500 mr-2 w-5"></i> {{ $amenity }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm italic">No amenities listed.</p>
                @endif
            </div>

        </div>
    </div>
    
    <div class="bg-gray-50 border-t border-gray-100 px-6 py-4 flex justify-between text-xs text-gray-500">
        <span>Created: {{ $property->created_at->format('M d, Y h:i A') }}</span>
        <span>Last Updated: {{ $property->updated_at->format('M d, Y h:i A') }}</span>
    </div>
</div>

@endsection
