@extends('admin.layouts.app')

@section('title', 'Reports & Analytics')
@section('header', 'Reports & Analytics')

@section('content')

<!-- Controls -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-4 rounded-lg shadow-sm border border-gray-100 gap-4">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-end gap-3 w-full md:w-auto">
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Date Range</label>
            <select name="date_range" id="date_range" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm border p-2">
                <option value="today" {{ $dateRange == 'today' ? 'selected' : '' }}>Today</option>
                <option value="yesterday" {{ $dateRange == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                <option value="last_7_days" {{ $dateRange == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="last_30_days" {{ $dateRange == 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                <option value="this_month" {{ $dateRange == 'this_month' ? 'selected' : '' }}>This Month</option>
                <option value="last_month" {{ $dateRange == 'last_month' ? 'selected' : '' }}>Last Month</option>
                <option value="this_year" {{ $dateRange == 'this_year' ? 'selected' : '' }}>This Year</option>
                <option value="custom" {{ $dateRange == 'custom' ? 'selected' : '' }}>Custom Range</option>
            </select>
        </div>
        
        <div id="custom_dates" class="{{ $dateRange == 'custom' ? 'flex' : 'hidden' }} gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Start</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="rounded-md border-gray-300 shadow-sm text-sm border p-2">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">End</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="rounded-md border-gray-300 shadow-sm text-sm border p-2">
            </div>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
            Apply Filter
        </button>
    </form>
    
    <div class="flex gap-2">
        <a href="{{ route('admin.reports.print', request()->all()) }}" target="_blank" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50 flex items-center">
            <i class="fas fa-print mr-2"></i> Print
        </a>
        <a href="{{ route('admin.reports.export.csv', request()->all()) }}" class="bg-white border border-gray-300 text-green-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-green-50 flex items-center">
            <i class="fas fa-file-csv mr-2"></i> Export CSV
        </a>
    </div>
</div>

<div class="mb-4">
    <h2 class="text-gray-500 text-sm font-medium">Showing data for: <span class="text-gray-900 font-bold">{{ $dateRangeLabel }}</span></h2>
</div>

<!-- Overview Stats -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-blue-500">
        <p class="text-xs text-gray-500 uppercase font-semibold">Total Properties</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_properties']) }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-green-500">
        <p class="text-xs text-gray-500 uppercase font-semibold">Active Properties</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['active_properties']) }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-purple-500">
        <p class="text-xs text-gray-500 uppercase font-semibold">Sold/Rented</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['sold_properties'] + $stats['rented_properties']) }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-indigo-500">
        <p class="text-xs text-gray-500 uppercase font-semibold">Total Projects</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_projects']) }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-yellow-500">
        <p class="text-xs text-gray-500 uppercase font-semibold">Total Inquiries</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_inquiries']) }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-teal-500">
        <p class="text-xs text-gray-500 uppercase font-semibold">Total Users</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_users']) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Property Analytics -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800">Property Analytics</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-500">For Sale</p>
                    <p class="text-xl font-bold text-gray-800">{{ $propertiesByPurpose->where('purpose', 'buy')->first()->count ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">For Rent</p>
                    <p class="text-xl font-bold text-gray-800">{{ $propertiesByPurpose->where('purpose', 'rent')->first()->count ?? 0 }}</p>
                </div>
            </div>
            
            <h4 class="text-sm font-medium text-gray-700 mb-3 border-b pb-2">By Status</h4>
            <div class="h-48 mb-6">
                <canvas id="propertyStatusChart"></canvas>
            </div>

            <div class="space-y-2 mb-6">
                @foreach($propertiesByStatus as $stat)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $stat->status) }}</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stat->count }}</span>
                </div>
                <!-- Progress bar visualization -->
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $stats['total_properties'] > 0 ? ($stat->count / $stats['total_properties'] * 100) : 0 }}%"></div>
                </div>
                @endforeach
            </div>

            <!-- Properties By Property Type -->
            <h4 class="text-sm font-medium text-gray-700 mb-3 border-b pb-2">By Property Type</h4>
            <div class="space-y-2 mb-6">
                @foreach($propertiesByType as $type)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">{{ $type->property_type }}</span>
                    <span class="text-sm font-medium text-gray-900">{{ $type->count }}</span>
                </div>
                @endforeach
            </div>

            <!-- Project Analytics -->
            <h4 class="text-sm font-medium text-gray-700 mb-3 border-b pb-2">Project Analytics</h4>
            <div class="space-y-2">
                @foreach($projectsByStatus as $pstat)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">{{ $pstat->status }}</span>
                    <span class="text-sm font-medium text-gray-900">{{ $pstat->count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Activity Over Time & Locations -->
    <div class="space-y-6">
        <!-- Inquiry Stats -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-medium text-gray-800">Inquiry Pipeline</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    <div class="bg-blue-50 p-3 rounded">
                        <p class="text-xs text-blue-800 font-semibold mb-1">New</p>
                        <p class="text-lg font-bold text-blue-900">{{ $stats['new_inquiries'] }}</p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded">
                        <p class="text-xs text-yellow-800 font-semibold mb-1">In Progress</p>
                        <p class="text-lg font-bold text-yellow-900">{{ $inquiriesByStatus->where('status', 'In Progress')->first()->count ?? 0 }}</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded">
                        <p class="text-xs text-green-800 font-semibold mb-1">Converted</p>
                        <p class="text-lg font-bold text-green-900">{{ $stats['converted_inquiries'] }}</p>
                    </div>
                    <div class="bg-red-50 p-3 rounded">
                        <p class="text-xs text-red-800 font-semibold mb-1">Spam/Closed</p>
                        <p class="text-lg font-bold text-red-900">{{ ($inquiriesByStatus->where('status', 'Closed')->first()->count ?? 0) + ($inquiriesByStatus->where('status', 'Spam')->first()->count ?? 0) }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Activity Chart -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-medium text-gray-800">Activity Over Time</h3>
            </div>
            <div class="p-6 h-64">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
        
        <!-- Location Analytics -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-medium text-gray-800">Top Locations (Cities)</h3>
            </div>
            <div class="p-6">
                @if($propertiesByCity->count() > 0)
                <ul class="space-y-3">
                    @foreach($propertiesByCity as $loc)
                    <li class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-red-400 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">{{ $loc->city }}</span>
                        </div>
                        <span class="text-sm text-gray-500 font-semibold">{{ $loc->count }} properties</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-sm text-gray-500 italic">No location data available for this period.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Agents Performance -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-800">Agent Performance</h3>
        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">{{ $stats['total_agents'] }} Agents</span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Properties</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Inquiries</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($agents as $agent)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                                {{ substr($agent->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $agent->name }}</p>
                                <p class="text-xs text-gray-500">{{ $agent->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="text-sm font-bold {{ $agent->properties_count > 0 ? 'text-gray-900' : 'text-gray-400' }}">{{ $agent->properties_count }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="text-sm font-bold {{ $agent->assigned_inquiries_count > 0 ? 'text-gray-900' : 'text-gray-400' }}">{{ $agent->assigned_inquiries_count }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 text-sm">No agent data available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('date_range').addEventListener('change', function() {
            const customDiv = document.getElementById('custom_dates');
            if (this.value === 'custom') {
                customDiv.classList.remove('hidden');
                customDiv.classList.add('flex');
            } else {
                customDiv.classList.add('hidden');
                customDiv.classList.remove('flex');
            }
        });

        // Property Status Chart
        const statusCtx = document.getElementById('propertyStatusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($propertiesByStatus->pluck('status')->map(function($s) { return ucwords(str_replace('_', ' ', $s)); })) !!},
                    datasets: [{
                        data: {!! json_encode($propertiesByStatus->pluck('count')) !!},
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#6366f1', '#ef4444', '#8b5cf6']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }

        // Activity Chart
        const activityCtx = document.getElementById('activityChart');
        if (activityCtx) {
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($propertyActivity->pluck('date')) !!},
                    datasets: [{
                        label: 'Properties Created',
                        data: {!! json_encode($propertyActivity->pluck('count')) !!},
                        borderColor: '#3b82f6',
                        tension: 0.1,
                        fill: true,
                        backgroundColor: 'rgba(59, 130, 246, 0.1)'
                    },
                    {
                        label: 'Inquiries Received',
                        data: {!! json_encode($inquiryActivity->pluck('count')) !!},
                        borderColor: '#f59e0b',
                        tension: 0.1
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });
        }
    });
</script>
@endsection
