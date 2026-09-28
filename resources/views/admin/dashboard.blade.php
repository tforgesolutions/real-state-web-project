@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Properties Stats -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Properties</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalProperties }}</p>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-full">
                    <i class="fas fa-building text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">For Sale</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $forSaleProperties }}</p>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-full">
                    <i class="fas fa-tags text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">For Rent</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $forRentProperties }}</p>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-full">
                    <i class="fas fa-key text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Featured Properties</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $featuredProperties }}</p>
                </div>
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-full">
                    <i class="fas fa-star text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Sold Properties</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $soldProperties }}</p>
                </div>
                <div class="p-3 bg-red-50 text-red-600 rounded-full">
                    <i class="fas fa-handshake text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Rented Properties</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $rentedProperties }}</p>
                </div>
                <div class="p-3 bg-purple-50 text-purple-600 rounded-full">
                    <i class="fas fa-door-open text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Projects Stats -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Projects</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalProjects }}</p>
                </div>
                <div class="p-3 bg-teal-50 text-teal-600 rounded-full">
                    <i class="fas fa-city text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Projects</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $activeProjects }}</p>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-full">
                    <i class="fas fa-hammer text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Completed Projects</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $completedProjects }}</p>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-full">
                    <i class="fas fa-check-double text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Users & Inquiries -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="p-3 bg-orange-50 text-orange-600 rounded-full">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Leads</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalInquiries }}</p>
                </div>
                <div class="p-3 bg-red-50 text-red-600 rounded-full">
                    <i class="fas fa-envelope text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">New Inquiries</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $newInquiries }}</p>
                </div>
                <div class="p-3 bg-pink-50 text-pink-600 rounded-full">
                    <i class="fas fa-bell text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Dashboard Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Area (Recent Properties & Inquiries) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Recent Properties -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Properties</h3>
                    <a href="{{ route('admin.properties.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
                </div>
                <div class="p-0">
                    @if(count($recentProperties) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentProperties as $property)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $property->title ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $property->property_type ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $property->city ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        ${{ number_format($property->price ?? 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $property->status ?? 'Active' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            No properties found.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Inquiries -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Inquiries</h3>
                    <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
                </div>
                <div class="p-0">
                    @if(count($recentInquiries) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">View</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentInquiries as $inq)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($inq->name, 20) }}</div>
                                        <div class="text-xs text-gray-500">{{ $inq->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $inq->inquiry_type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $inq->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <a href="{{ route('admin.inquiries.show', $inq->id) }}" class="text-indigo-600 hover:text-indigo-900">Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                            <p>No new inquiries at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Sidebar Area (Quick Actions & Status) -->
        <div class="space-y-8">
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors border border-gray-100 group">
                        <i class="fas fa-plus-circle text-2xl text-gray-400 group-hover:text-blue-500 mb-2"></i>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Add Property</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors border border-gray-100 group">
                        <i class="fas fa-folder-plus text-2xl text-gray-400 group-hover:text-blue-500 mb-2"></i>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Add Project</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors border border-gray-100 group">
                        <i class="fas fa-user-plus text-2xl text-gray-400 group-hover:text-blue-500 mb-2"></i>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Add Agent</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors border border-gray-100 group">
                        <i class="fas fa-envelope-open-text text-2xl text-gray-400 group-hover:text-blue-500 mb-2"></i>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Inquiries</span>
                    </a>
                </div>
            </div>

            <!-- Property Status Overview -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Property Status</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Active</span>
                            <span class="font-medium">{{ $activeProperties }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalProperties > 0 ? ($activeProperties / $totalProperties) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Pending</span>
                            <span class="font-medium">{{ $totalProperties - $activeProperties }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $totalProperties > 0 ? (($totalProperties - $activeProperties) / $totalProperties) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inquiry Pipeline -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Inquiry Pipeline</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-blue-600 font-medium">New / Contacted</span>
                            <span class="font-medium">{{ $newInquiries }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $totalInquiries > 0 ? ($newInquiries / $totalInquiries) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-yellow-600 font-medium">In Progress / Follow Up</span>
                            <span class="font-medium">{{ $inProgressInquiries + $followUpInquiries }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $totalInquiries > 0 ? (($inProgressInquiries + $followUpInquiries) / $totalInquiries) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-green-600 font-medium">Converted</span>
                            <span class="font-medium">{{ $convertedInquiries }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalInquiries > 0 ? ($convertedInquiries / $totalInquiries) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
