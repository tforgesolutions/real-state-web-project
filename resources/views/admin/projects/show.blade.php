@extends('admin.layouts.app')

@section('title', 'View Project')
@section('header', 'View Project')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.projects.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Projects
    </a>
    <div class="space-x-2 flex">
        <a href="{{ route('admin.projects.edit', $project->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
            <i class="fas fa-edit mr-2"></i> Edit
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
        <!-- Images -->
        <div class="lg:col-span-1 border-b lg:border-b-0 lg:border-r border-gray-100 p-6 bg-gray-50 flex flex-col items-center">
            @if(!empty($project->images) && count($project->images) > 0)
                <img src="{{ Storage::url($project->images[0]) }}" alt="{{ $project->title }}" class="w-full h-64 object-cover rounded-lg shadow-sm mb-4">
                <div class="grid grid-cols-4 gap-2 w-full">
                    @foreach(array_slice($project->images, 1, 4) as $img)
                        <img src="{{ Storage::url($img) }}" class="w-full h-16 object-cover rounded-md opacity-80 hover:opacity-100 cursor-pointer border border-gray-200">
                    @endforeach
                </div>
            @else
                <div class="w-full h-64 bg-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-400 mb-4 shadow-sm">
                    <i class="fas fa-building text-5xl mb-2"></i>
                    <span>No images available</span>
                </div>
            @endif

            <div class="w-full mt-6 space-y-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Developer Info</h4>
                    <p class="text-sm font-medium text-gray-900"><i class="fas fa-hard-hat w-5 text-blue-500"></i> {{ $project->developer }}</p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Contact Info</h4>
                    <p class="text-sm text-gray-800"><i class="fas fa-phone w-5 text-gray-400"></i> {{ $project->contact_phone ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-800 mt-1"><i class="fas fa-envelope w-5 text-gray-400"></i> {{ $project->contact_email ?? 'N/A' }}</p>
                    @if($project->website_url)
                    <p class="text-sm text-blue-600 mt-1"><i class="fas fa-globe w-5 text-gray-400"></i> <a href="{{ $project->website_url }}" target="_blank" class="hover:underline">Visit Website</a></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="lg:col-span-2 p-6 md:p-8">
            <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        @php
                            $statusColors = [
                                'upcoming' => 'bg-blue-100 text-blue-800',
                                'ongoing' => 'bg-yellow-100 text-yellow-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'on_hold' => 'bg-gray-100 text-gray-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $color = $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800';
                            $label = str_replace('_', ' ', $project->status);
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $color }}">
                            {{ $label }}
                        </span>
                        
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize bg-indigo-100 text-indigo-800">
                            {{ $project->project_type }}
                        </span>
                        
                        @if($project->is_featured)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 flex items-center">
                                <i class="fas fa-star text-[10px] mr-1"></i> Featured
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $project->title }}</h1>
                    <p class="text-gray-500 text-sm flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i> 
                        {{ $project->address ? $project->address . ', ' : '' }}
                        {{ $project->location }}
                    </p>
                </div>
                
                <div class="text-right">
                    <p class="text-sm text-gray-500">Starting from</p>
                    <p class="text-2xl font-bold text-blue-600">${{ number_format($project->starting_price ?? 0) }}</p>
                    <p class="text-sm text-gray-500">ID: {{ $project->reference_id }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-8">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Units</p>
                    <p class="font-medium text-gray-900"><i class="fas fa-building text-blue-500 mr-2"></i>{{ $project->total_units ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Available Units</p>
                    <p class="font-medium text-gray-900"><i class="fas fa-door-open text-blue-500 mr-2"></i>{{ $project->available_units ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Sold Units</p>
                    <p class="font-medium text-gray-900"><i class="fas fa-check-circle text-blue-500 mr-2"></i>{{ $project->sold_units ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Completion</p>
                    <p class="font-medium text-gray-900"><i class="fas fa-calendar-alt text-blue-500 mr-2"></i>{{ $project->completion_date ? $project->completion_date->format('M Y') : 'N/A' }}</p>
                </div>
            </div>

            <div class="mb-8 border-t border-gray-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                <div class="text-gray-700 whitespace-pre-line text-sm leading-relaxed">
                    {{ $project->description ?: 'No description provided.' }}
                </div>
            </div>

            <div class="mb-2 border-t border-gray-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Amenities</h3>
                @if(!empty($project->amenities) && is_array($project->amenities) && count($project->amenities) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-3 gap-x-4">
                        @foreach($project->amenities as $amenity)
                            <div class="flex items-center text-gray-700 text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i> {{ $amenity }}
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
        <span>Created: {{ $project->created_at->format('M d, Y h:i A') }}</span>
        <span>Last Updated: {{ $project->updated_at->format('M d, Y h:i A') }}</span>
    </div>
</div>

@endsection
