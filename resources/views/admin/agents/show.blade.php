@extends('admin.layouts.app')

@section('title', 'View Agent')
@section('header', 'View Agent')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.agents.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Agents
    </a>
    <div class="space-x-2 flex">
        <a href="{{ route('admin.agents.edit', $agent->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
            <i class="fas fa-edit mr-2"></i> Edit Profile
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Left Column: Profile -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 flex flex-col items-center border-b border-gray-100">
                <div class="h-32 w-32 rounded-full overflow-hidden bg-gray-100 border-4 border-white shadow-lg mb-4">
                    @if($agent->profile_photo)
                        <img src="{{ Storage::url($agent->profile_photo) }}" alt="{{ $agent->name }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-gray-500 font-bold text-4xl bg-blue-100 text-blue-600">
                            {{ substr($agent->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-gray-900 text-center">{{ $agent->name }}</h2>
                <p class="text-gray-500 text-sm text-center mb-3">{{ $agent->designation ?? 'Real Estate Agent' }}</p>
                
                <div class="flex items-center gap-2 mb-4">
                    @php
                        $statusColors = [
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-gray-100 text-gray-800',
                            'suspended' => 'bg-red-100 text-red-800',
                        ];
                        $color = $statusColors[$agent->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $color }}">
                        {{ $agent->status }}
                    </span>
                    
                    @if($agent->is_featured)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 flex items-center">
                            <i class="fas fa-star text-[10px] mr-1"></i> Featured
                        </span>
                    @endif
                </div>

                <div class="flex justify-center space-x-3 w-full">
                    @if($agent->facebook_url)
                        <a href="{{ $agent->facebook_url }}" target="_blank" class="h-8 w-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                    @endif
                    @if($agent->instagram_url)
                        <a href="{{ $agent->instagram_url }}" target="_blank" class="h-8 w-8 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center hover:bg-pink-600 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                    @endif
                    @if($agent->linkedin_url)
                        <a href="{{ $agent->linkedin_url }}" target="_blank" class="h-8 w-8 rounded-full bg-blue-50 text-blue-800 flex items-center justify-center hover:bg-blue-800 hover:text-white transition-colors">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                    @endif
                    @if($agent->website_url)
                        <a href="{{ $agent->website_url }}" target="_blank" class="h-8 w-8 rounded-full bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-gray-600 hover:text-white transition-colors">
                            <i class="fas fa-globe text-sm"></i>
                        </a>
                    @endif
                </div>
            </div>

            <div class="p-6 bg-gray-50 space-y-4">
                <div>
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Contact</h4>
                    <p class="text-sm text-gray-800 flex items-center"><i class="fas fa-envelope w-5 text-gray-400"></i> <a href="mailto:{{ $agent->email }}" class="hover:text-blue-600">{{ $agent->email }}</a></p>
                    <p class="text-sm text-gray-800 mt-2 flex items-center"><i class="fas fa-phone w-5 text-gray-400"></i> {{ $agent->phone ?? 'N/A' }}</p>
                    @if($agent->whatsapp)
                    <p class="text-sm text-gray-800 mt-2 flex items-center"><i class="fab fa-whatsapp w-5 text-green-500"></i> {{ $agent->whatsapp }}</p>
                    @endif
                </div>
                <hr class="border-gray-200">
                <div>
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Agency Info</h4>
                    <p class="text-sm text-gray-800 flex items-center"><i class="fas fa-building w-5 text-gray-400"></i> {{ $agent->agency ?? 'Independent' }}</p>
                    <p class="text-sm text-gray-800 mt-2 flex items-center"><i class="fas fa-briefcase w-5 text-gray-400"></i> {{ $agent->experience_years ? $agent->experience_years . ' Years Experience' : 'N/A' }}</p>
                </div>
                <hr class="border-gray-200">
                <div>
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Location</h4>
                    <p class="text-sm text-gray-800 flex items-start">
                        <i class="fas fa-map-marker-alt w-5 text-gray-400 mt-1"></i> 
                        <span>
                            {{ $agent->address ? $agent->address . ',' : '' }}<br>
                            {{ $agent->city ? $agent->city . ',' : '' }} {{ $agent->country }}
                            @if(!$agent->address && !$agent->city && !$agent->country)
                                N/A
                            @endif
                        </span>
                    </p>
                </div>
            </div>
            <div class="bg-white border-t border-gray-100 px-6 py-4 text-xs text-gray-500 text-center">
                Member since {{ $agent->created_at->format('M d, Y') }}
            </div>
        </div>
    </div>

    <!-- Right Column: Bio & Properties -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Bio -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">About {{ explode(' ', trim($agent->name))[0] }}</h3>
            <div class="text-gray-700 whitespace-pre-line text-sm leading-relaxed">
                {{ $agent->bio ?: 'No biography provided.' }}
            </div>
        </div>

        <!-- Assigned Properties -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Properties Managed by This Agent</h3>
                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-blue-800 bg-blue-100 rounded-full">{{ $properties->total() }}</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type / Purpose</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($properties as $property)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($property->title, 30) }}</div>
                                <div class="text-xs text-gray-500">{{ $property->city }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $property->property_type }}</div>
                                <div class="text-xs text-gray-500 capitalize">For {{ $property->purpose === 'buy' ? 'Sale' : 'Rent' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                ${{ number_format($property->price) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $propColors = [
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        'pending_review' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'sold' => 'bg-blue-100 text-blue-800',
                                        'rented' => 'bg-purple-100 text-purple-800',
                                        'inactive' => 'bg-red-100 text-red-800',
                                    ];
                                    $pcolor = $propColors[$property->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full capitalize {{ $pcolor }}">
                                    {{ str_replace('_', ' ', $property->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.properties.show', $property->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded" title="View Property"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-building text-3xl mb-3 text-gray-300"></i>
                                <p class="text-sm">No properties assigned to this agent yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($properties->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $properties->links() }}
            </div>
            @endif
        </div>
        
    </div>
</div>
@endsection
