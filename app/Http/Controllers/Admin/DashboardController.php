<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Properties Stats
        $totalProperties = class_exists(Property::class) ? Property::count() : 0;
        $forSaleProperties = class_exists(Property::class) ? Property::where('purpose', 'buy')->count() : 0;
        $forRentProperties = class_exists(Property::class) ? Property::where('purpose', 'rent')->count() : 0;
        $featuredProperties = class_exists(Property::class) ? Property::where('is_featured', 1)->count() : 0;
        $soldProperties = class_exists(Property::class) ? Property::where('status', 'sold')->count() : 0;
        $rentedProperties = class_exists(Property::class) ? Property::where('status', 'rented')->count() : 0;
        
        $activeProperties = class_exists(Property::class) ? Property::where('status', 'approved')->count() : 0;
        
        // Users & Agents
        $totalUsers = class_exists(User::class) ? User::count() : 0;
        $totalAgents = class_exists(User::class) ? User::where('role', 'agent')->count() : 0; 
        
        // Projects Stats
        $totalProjects = class_exists(\App\Models\Project::class) ? \App\Models\Project::count() : 0;
        $activeProjects = class_exists(\App\Models\Project::class) ? \App\Models\Project::where('status', 'Ongoing')->count() : 0;
        $completedProjects = class_exists(\App\Models\Project::class) ? \App\Models\Project::where('status', 'Completed')->count() : 0;
        
        // Inquiries Stats
        $totalInquiries = class_exists(\App\Models\Inquiry::class) ? \App\Models\Inquiry::count() : 0;
        $newInquiries = class_exists(\App\Models\Inquiry::class) ? \App\Models\Inquiry::where('status', 'New')->count() : 0;
        
        $inProgressInquiries = class_exists(\App\Models\Inquiry::class) ? \App\Models\Inquiry::where('status', 'In Progress')->count() : 0;
        $followUpInquiries = class_exists(\App\Models\Inquiry::class) ? \App\Models\Inquiry::where('status', 'Follow Up')->count() : 0;
        $convertedInquiries = class_exists(\App\Models\Inquiry::class) ? \App\Models\Inquiry::where('status', 'Converted')->count() : 0;
        
        // Recent Activity / Data
        $recentProperties = class_exists(Property::class) ? Property::latest()->take(5)->get() : collect();
        $recentInquiries = class_exists(\App\Models\Inquiry::class) ? \App\Models\Inquiry::latest()->take(5)->get() : collect();

        return view('admin.dashboard', compact(
            'totalProperties',
            'forSaleProperties',
            'forRentProperties',
            'featuredProperties',
            'soldProperties',
            'rentedProperties',
            'activeProperties',
            'totalUsers',
            'totalAgents',
            'totalProjects',
            'activeProjects',
            'completedProjects',
            'totalInquiries',
            'newInquiries',
            'inProgressInquiries',
            'followUpInquiries',
            'convertedInquiries',
            'recentProperties',
            'recentInquiries'
        ));
    }
}
