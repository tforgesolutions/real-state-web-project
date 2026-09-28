<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Project;
use App\Models\User;
use App\Models\Inquiry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getReportData($request);
        return view('admin.reports.index', $data);
    }

    public function print(Request $request)
    {
        $data = $this->getReportData($request);
        $data['isPrint'] = true;
        return view('admin.reports.print', $data);
    }

    public function exportCsv(Request $request)
    {
        $data = $this->getReportData($request);
        
        $filename = "real_estate_report_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['REAL ESTATE SYSTEM REPORT - ' . $data['dateRangeLabel']]);
            fputcsv($file, []);
            
            // Overview
            fputcsv($file, ['--- OVERVIEW ---']);
            fputcsv($file, ['Metric', 'Count']);
            fputcsv($file, ['Total Properties', $data['stats']['total_properties']]);
            fputcsv($file, ['Active Properties', $data['stats']['active_properties']]);
            fputcsv($file, ['Sold Properties', $data['stats']['sold_properties']]);
            fputcsv($file, ['Rented Properties', $data['stats']['rented_properties']]);
            fputcsv($file, ['Total Projects', $data['stats']['total_projects']]);
            fputcsv($file, ['Active Projects', $data['stats']['active_projects']]);
            fputcsv($file, ['Total Agents', $data['stats']['total_agents']]);
            fputcsv($file, ['Total Users', $data['stats']['total_users']]);
            fputcsv($file, ['Total Inquiries', $data['stats']['total_inquiries']]);
            fputcsv($file, ['New Inquiries', $data['stats']['new_inquiries']]);
            fputcsv($file, ['Converted Inquiries', $data['stats']['converted_inquiries']]);
            fputcsv($file, []);
            
            // Property Status
            fputcsv($file, ['--- PROPERTY STATUS ---']);
            fputcsv($file, ['Status', 'Count']);
            foreach($data['propertiesByStatus'] as $item) {
                fputcsv($file, [$item->status, $item->count]);
            }
            fputcsv($file, []);
            
            // Properties By Purpose
            fputcsv($file, ['--- PROPERTY PURPOSE ---']);
            fputcsv($file, ['Purpose', 'Count']);
            foreach($data['propertiesByPurpose'] as $item) {
                fputcsv($file, [$item->purpose, $item->count]);
            }
            fputcsv($file, []);
            
            // Properties By City
            fputcsv($file, ['--- PROPERTIES BY CITY ---']);
            fputcsv($file, ['City', 'Count']);
            foreach($data['propertiesByCity'] as $item) {
                fputcsv($file, [$item->city, $item->count]);
            }
            fputcsv($file, []);
            
            // Agent Performance
            fputcsv($file, ['--- AGENT PERFORMANCE ---']);
            fputcsv($file, ['Agent Name', 'Assigned Properties', 'Assigned Inquiries']);
            foreach($data['agents'] as $agent) {
                fputcsv($file, [$agent->name, $agent->properties_count, $agent->assigned_inquiries_count]);
            }
            fputcsv($file, []);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    private function getReportData(Request $request)
    {
        $dateRange = $request->input('date_range', 'this_month');
        $startDate = null;
        $endDate = null;
        $dateRangeLabel = 'All Time';

        $now = Carbon::now();

        switch ($dateRange) {
            case 'today':
                $startDate = $now->copy()->startOfDay();
                $endDate = $now->copy()->endOfDay();
                $dateRangeLabel = 'Today';
                break;
            case 'yesterday':
                $startDate = $now->copy()->subDay()->startOfDay();
                $endDate = $now->copy()->subDay()->endOfDay();
                $dateRangeLabel = 'Yesterday';
                break;
            case 'last_7_days':
                $startDate = $now->copy()->subDays(6)->startOfDay();
                $endDate = $now->copy()->endOfDay();
                $dateRangeLabel = 'Last 7 Days';
                break;
            case 'last_30_days':
                $startDate = $now->copy()->subDays(29)->startOfDay();
                $endDate = $now->copy()->endOfDay();
                $dateRangeLabel = 'Last 30 Days';
                break;
            case 'this_month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $dateRangeLabel = 'This Month';
                break;
            case 'last_month':
                $startDate = $now->copy()->subMonth()->startOfMonth();
                $endDate = $now->copy()->subMonth()->endOfMonth();
                $dateRangeLabel = 'Last Month';
                break;
            case 'this_year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                $dateRangeLabel = 'This Year';
                break;
            case 'custom':
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $startDate = Carbon::parse($request->start_date)->startOfDay();
                    $endDate = Carbon::parse($request->end_date)->endOfDay();
                    $dateRangeLabel = $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y');
                }
                break;
        }

        // Apply global date filter to scopes if required
        $dateFilter = function ($query) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        };

        // Aggregations
        $stats = [
            'total_properties' => Property::where($dateFilter)->count(),
            'active_properties' => Property::where($dateFilter)->where('status', 'approved')->count(),
            'sold_properties' => Property::where($dateFilter)->where('status', 'sold')->count(),
            'rented_properties' => Property::where($dateFilter)->where('status', 'rented')->count(),
            'draft_properties' => Property::where($dateFilter)->where('status', 'draft')->count(),
            'inactive_properties' => Property::where($dateFilter)->where('status', 'inactive')->count(),
            'featured_properties' => Property::where($dateFilter)->where('is_featured', true)->count(),
            
            'total_projects' => Project::where($dateFilter)->count(),
            'active_projects' => Project::where($dateFilter)->whereIn('status', ['Upcoming', 'Ongoing'])->count(),
            
            'total_agents' => User::where($dateFilter)->where('role', 'agent')->count(),
            'total_users' => User::where($dateFilter)->where('role', 'user')->count(),
            
            'total_inquiries' => Inquiry::where($dateFilter)->count(),
            'new_inquiries' => Inquiry::where($dateFilter)->where('status', 'New')->count(),
            'converted_inquiries' => Inquiry::where($dateFilter)->where('status', 'Converted')->count(),
        ];

        // Groupings
        $propertiesByStatus = Property::where($dateFilter)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
            
        $propertiesByPurpose = Property::where($dateFilter)
            ->select('purpose', DB::raw('count(*) as count'))
            ->groupBy('purpose')
            ->get();

        $propertiesByCity = Property::where($dateFilter)
            ->select('city', DB::raw('count(*) as count'))
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $projectsByStatus = Project::where($dateFilter)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $inquiriesByStatus = Inquiry::where($dateFilter)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
            
        $usersByStatus = User::where($dateFilter)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
            
        $propertiesByType = Property::where($dateFilter)
            ->select('property_type', DB::raw('count(*) as count'))
            ->groupBy('property_type')
            ->get();

        // Agents report
        $agents = User::where('role', 'agent')
            ->withCount(['properties' => $dateFilter, 'assignedInquiries' => $dateFilter])
            ->orderByDesc('properties_count')
            ->get();
            
        // Activity over time
        $format = '%Y-%m-%d';
        if ($dateRange === 'this_year') {
            $format = '%Y-%m';
        }
        
        $propertyActivity = Property::where($dateFilter)
            ->select(DB::raw("DATE_FORMAT(created_at, '{$format}') as date"), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $inquiryActivity = Inquiry::where($dateFilter)
            ->select(DB::raw("DATE_FORMAT(created_at, '{$format}') as date"), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return compact(
            'dateRange', 'startDate', 'endDate', 'dateRangeLabel',
            'stats', 'propertiesByStatus', 'propertiesByPurpose', 
            'propertiesByCity', 'projectsByStatus', 'inquiriesByStatus',
            'usersByStatus', 'propertiesByType', 'agents', 
            'propertyActivity', 'inquiryActivity'
        );
    }
}
