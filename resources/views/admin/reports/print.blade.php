<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Report - {{ $dateRangeLabel }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background-color: white; }
            .no-print { display: none; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body class="bg-white text-gray-900 p-8">

    <div class="no-print mb-6 flex justify-end">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded font-medium shadow">Print Report</button>
        <button onclick="window.close()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded font-medium ml-2 shadow">Close</button>
    </div>

    <div class="text-center mb-8 border-b pb-4">
        <h1 class="text-3xl font-bold uppercase tracking-wider">Real Estate System Report</h1>
        <p class="text-gray-500 mt-2 text-lg">Period: <span class="font-semibold text-gray-800">{{ $dateRangeLabel }}</span></p>
        <p class="text-xs text-gray-400 mt-1">Generated on {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}</p>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Executive Summary</h2>
        <div class="grid grid-cols-4 gap-4 mb-4">
            <div class="bg-gray-50 p-4 rounded border">
                <p class="text-sm text-gray-500 uppercase">Total Properties</p>
                <p class="text-2xl font-bold">{{ number_format($stats['total_properties']) }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded border">
                <p class="text-sm text-gray-500 uppercase">Active Properties</p>
                <p class="text-2xl font-bold">{{ number_format($stats['active_properties']) }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded border">
                <p class="text-sm text-gray-500 uppercase">Total Projects</p>
                <p class="text-2xl font-bold">{{ number_format($stats['total_projects']) }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded border">
                <p class="text-sm text-gray-500 uppercase">Total Inquiries</p>
                <p class="text-2xl font-bold">{{ number_format($stats['total_inquiries']) }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-8 mb-8">
        <div>
            <h3 class="text-lg font-bold mb-3 border-b pb-1">Property Status</h3>
            <table class="w-full text-sm border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 text-left">Status</th>
                        <th class="border p-2 text-right">Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($propertiesByStatus as $stat)
                    <tr>
                        <td class="border p-2 capitalize">{{ str_replace('_', ' ', $stat->status) }}</td>
                        <td class="border p-2 text-right font-bold">{{ $stat->count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <h3 class="text-lg font-bold mb-3 border-b pb-1">Property Purpose</h3>
            <table class="w-full text-sm border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 text-left">Purpose</th>
                        <th class="border p-2 text-right">Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($propertiesByPurpose as $stat)
                    <tr>
                        <td class="border p-2 capitalize">{{ $stat->purpose == 'buy' ? 'For Sale' : 'For Rent' }}</td>
                        <td class="border p-2 text-right font-bold">{{ $stat->count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-8 mb-8 page-break">
        <div>
            <h3 class="text-lg font-bold mb-3 border-b pb-1">Top Locations</h3>
            <table class="w-full text-sm border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 text-left">City</th>
                        <th class="border p-2 text-right">Properties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($propertiesByCity as $loc)
                    <tr>
                        <td class="border p-2">{{ $loc->city }}</td>
                        <td class="border p-2 text-right font-bold">{{ $loc->count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <h3 class="text-lg font-bold mb-3 border-b pb-1">Agent Overview</h3>
            <table class="w-full text-sm border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 text-left">Agent</th>
                        <th class="border p-2 text-center">Properties</th>
                        <th class="border p-2 text-center">Inquiries</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agents as $agent)
                    <tr>
                        <td class="border p-2">{{ $agent->name }}</td>
                        <td class="border p-2 text-center font-bold">{{ $agent->properties_count }}</td>
                        <td class="border p-2 text-center font-bold">{{ $agent->assigned_inquiries_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center text-xs text-gray-400 mt-12 border-t pt-4">
        CONFIDENTIAL REPORT - For Internal Use Only
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() { window.print(); }, 500);
        }
    </script>
</body>
</html>
