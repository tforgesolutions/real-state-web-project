<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    $featuredProperties = \App\Models\Property::where('is_featured', 1)->take(6)->get();
    $featuredProjects = \App\Models\Project::where('is_featured', 1)->take(3)->get();
    $featuredAgents = \App\Models\User::where('role', 'agent')->where('is_featured', 1)->take(4)->get();
    
    return view('welcome', compact('featuredProperties', 'featuredProjects', 'featuredAgents'));
})->name('home');

Route::get('/properties', function (Request $request) {
    $layout = $request->query('layout', 'grid');
    
    $query = \App\Models\Property::where('status', 'approved');
    
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where(function($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('city', 'like', "%{$keyword}%")
              ->orWhere('area_locality', 'like', "%{$keyword}%");
        });
    }
    if ($request->filled('purpose')) {
        $query->where('purpose', strtolower($request->purpose));
    }
    if ($request->filled('type')) {
        $query->where('property_type', $request->type);
    }
    if ($request->filled('city')) {
        $query->where('city', $request->city);
    }
    if ($request->filled('beds')) {
        $query->where('bedrooms', '>=', (int)$request->beds);
    }
    
    $realProperties = $query->latest()->get();
    
    return view('properties.index', compact('layout', 'realProperties'));
})->name('properties.index');

Route::get('/properties/{property}', function ($property) {
    $realProperty = \App\Models\Property::where('slug', $property)->first();
    // If we have a real property, we could pass it down, but the show blade relies heavily on dummy data.
    // For now, we'll pass it if it exists.
    return view('properties.show', compact('property', 'realProperty'));
})->name('properties.show');

Route::get('/projects', function (Illuminate\Http\Request $request) {
    $query = \App\Models\Project::whereNotIn('status', ['Draft', 'Inactive']);
    
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where(function($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('location', 'like', "%{$keyword}%")
              ->orWhere('developer', 'like', "%{$keyword}%");
        });
    }
    
    if ($request->filled('type') && $request->type !== 'Any Type') {
        $query->where('project_type', $request->type);
    }
    
    if ($request->filled('status') && $request->status !== 'All') {
        $query->where('status', $request->status);
    }
    
    $projects = $query->latest()->paginate(10);
    return view('projects.index', compact('projects'));
})->name('projects.index');

Route::get('/projects/{project}', function ($projectSlug) {
    $project = \App\Models\Project::where('slug', $projectSlug)
                  ->whereNotIn('status', ['Draft', 'Inactive'])
                  ->firstOrFail();
    return view('projects.show', compact('project'));
})->name('projects.show');

Route::get('/favorites', function () {
    return view('favorites.index');
})->name('favorites.index');

Route::get('/compare', function () {
    return view('compare.index');
})->name('compare.index');

Route::get('/blog', function () {
    return view('blog.index');
})->name('blog.index');

Route::get('/blog/category/{category}', function ($category) {
    return view('blog.index', compact('category'));
})->name('blog.category');

Route::get('/blog/{slug}', function ($slug) {
    return view('blog.show', compact('slug'));
})->name('blog.show');

Route::get('/contact', function () {
    return view('contact.index');
})->name('contact.index');
Route::post('/contact', [\App\Http\Controllers\InquiryController::class, 'store'])->name('contact.store');

Route::get('/about', function () {
    return view('about.index');
})->name('about.index');

Route::get('/faq', function () {
    return view('faq.index');
})->name('faq.index');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
    
    // Password reset (UI only for this step)
    Route::get('/forgot-password', function() { return view('auth.forgot-password'); })->name('password.request');
    Route::get('/reset-password/{token}', function($token) { return view('auth.reset-password', ['token' => $token]); })->name('password.reset');
});

Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Account Routes
Route::middleware('auth')->group(function () {
    // List Property
    Route::get('/list-property', [\App\Http\Controllers\PropertyController::class, 'create'])->name('properties.create');
    Route::post('/list-property', [\App\Http\Controllers\PropertyController::class, 'store'])->name('properties.store');
    Route::get('/list-property/success/{property}', [\App\Http\Controllers\PropertyController::class, 'success'])->name('properties.success');
});

Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AccountController::class, 'index'])->name('index');
    Route::get('/profile', [\App\Http\Controllers\AccountController::class, 'profile'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\AccountController::class, 'updateProfile'])->name('profile.update');
    Route::get('/favorites', [\App\Http\Controllers\AccountController::class, 'favorites'])->name('favorites');
    Route::get('/compare', [\App\Http\Controllers\AccountController::class, 'compare'])->name('compare');
    Route::get('/inquiries', [\App\Http\Controllers\AccountController::class, 'inquiries'])->name('inquiries');
    Route::get('/recently-viewed', [\App\Http\Controllers\AccountController::class, 'recentlyViewed'])->name('recently-viewed');
    Route::get('/settings', [\App\Http\Controllers\AccountController::class, 'settings'])->name('settings');
    
    // My Properties
    Route::get('/my-properties', [\App\Http\Controllers\PropertyController::class, 'myProperties'])->name('my-properties.index');
    Route::get('/my-properties/{property}/edit', [\App\Http\Controllers\PropertyController::class, 'edit'])->name('my-properties.edit');
    Route::put('/my-properties/{property}', [\App\Http\Controllers\PropertyController::class, 'update'])->name('my-properties.update');
    Route::delete('/my-properties/{property}', [\App\Http\Controllers\PropertyController::class, 'destroy'])->name('my-properties.destroy');
    
    // Alerts
    Route::get('/alerts', [\App\Http\Controllers\AlertController::class, 'index'])->name('alerts.index');
    Route::get('/alerts/create', [\App\Http\Controllers\AlertController::class, 'create'])->name('alerts.create');
    Route::post('/alerts', [\App\Http\Controllers\AlertController::class, 'store'])->name('alerts.store');
    Route::get('/alerts/{alert}/edit', [\App\Http\Controllers\AlertController::class, 'edit'])->name('alerts.edit');
    Route::put('/alerts/{alert}', [\App\Http\Controllers\AlertController::class, 'update'])->name('alerts.update');
    Route::delete('/alerts/{alert}', [\App\Http\Controllers\AlertController::class, 'destroy'])->name('alerts.destroy');
    Route::patch('/alerts/{alert}/status', [\App\Http\Controllers\AlertController::class, 'toggleStatus'])->name('alerts.status');
    Route::get('/alerts/{alert}', [\App\Http\Controllers\AlertController::class, 'show'])->name('alerts.show');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::patch('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
});

Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::put('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update')->middleware('auth');
Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy')->middleware('auth');

Route::get('/locations', function () {
    $locations = \App\Models\Location::where('status', 'Active')
                    ->where(function($q) {
                        $q->where('type', 'City')->orWhereNull('parent_id');
                    })
                    ->withCount(['properties', 'projects'])
                    ->orderBy('properties_count', 'desc')
                    ->get();
    return view('locations.index', compact('locations'));
})->name('locations.index');

Route::get('/locations/{city}', function ($city) {
    $location = \App\Models\Location::where('name', 'like', str_replace('-', ' ', $city))->first();
    if(!$location) {
        return redirect()->route('properties.index', ['keyword' => str_replace('-', ' ', $city)]);
    }
    
    $areas = \App\Models\Location::where('parent_id', $location->id)->where('status', 'Active')->withCount('properties')->get();
    return view('locations.city', compact('city', 'location', 'areas'));
})->name('locations.city');

Route::get('/locations/{city}/{area}', function ($city, $area) {
    return redirect()->route('properties.index', ['keyword' => str_replace('-', ' ', $area)]);
})->name('locations.area');

Route::get('/agents', function (Request $request) {
    $query = \App\Models\User::where('role', 'agent')->where('status', 'active');
    
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where(function($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('city', 'like', "%{$keyword}%")
              ->orWhere('agency', 'like', "%{$keyword}%");
        });
    }
    
    // Sort logic (just basic for now)
    if ($request->filled('sort')) {
        if ($request->sort === 'Name (A-Z)') {
            $query->orderBy('name', 'asc');
        } elseif ($request->sort === 'Highest Rated') {
            $query->orderBy('is_featured', 'desc');
        }
    } else {
        $query->orderBy('is_featured', 'desc')->latest();
    }
    
    $agents = $query->withCount('properties')->paginate(12);
    
    return view('agents.index', compact('agents'));
})->name('agents.index');

Route::get('/agents/{id}', function ($id) {
    $agent = \App\Models\User::where('role', 'agent')->where('status', 'active')->findOrFail($id);
    // Fetch properties for this agent
    $agentProperties = \App\Models\Property::where('user_id', $agent->id)
        ->orWhere('agent_id', $agent->id)
        ->where('status', 'approved')
        ->latest()
        ->paginate(6);
        
    return view('agents.show', compact('agent', 'agentProperties'));
})->name('agents.show');

Route::get('/agencies', function () {
    return view('agencies.index');
})->name('agencies.index');

Route::get('/agencies/{agency}', function ($agency) {
    return view('agencies.show', compact('agency'));
})->name('agencies.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
        Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

        // Placeholders for future modules
        Route::patch('properties/{property}/featured', [\App\Http\Controllers\Admin\PropertyController::class, 'toggleFeatured'])->name('properties.featured');
        Route::delete('properties/{property}/image', [\App\Http\Controllers\Admin\PropertyController::class, 'deleteImage'])->name('properties.delete-image');
        Route::resource('properties', \App\Http\Controllers\Admin\PropertyController::class);
        Route::patch('projects/{project}/featured', [\App\Http\Controllers\Admin\ProjectController::class, 'toggleFeatured'])->name('projects.featured');
        Route::delete('projects/{project}/image', [\App\Http\Controllers\Admin\ProjectController::class, 'deleteImage'])->name('projects.delete-image');
        Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);
        Route::patch('agents/{agent}/featured', [\App\Http\Controllers\Admin\AgentController::class, 'toggleFeatured'])->name('agents.featured');
        Route::delete('agents/{agent}/photo', [\App\Http\Controllers\Admin\AgentController::class, 'removePhoto'])->name('agents.remove-photo');
        Route::resource('agents', \App\Http\Controllers\Admin\AgentController::class);
        Route::delete('users/{user}/photo', [\App\Http\Controllers\Admin\UserController::class, 'removePhoto'])->name('users.remove-photo');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::patch('inquiries/{inquiry}/status', [\App\Http\Controllers\Admin\InquiryController::class, 'updateStatus'])->name('inquiries.status');
        Route::patch('inquiries/{inquiry}/priority', [\App\Http\Controllers\Admin\InquiryController::class, 'updatePriority'])->name('inquiries.priority');
        Route::patch('inquiries/{inquiry}/assign', [\App\Http\Controllers\Admin\InquiryController::class, 'assignAgent'])->name('inquiries.assign');
        Route::patch('inquiries/{inquiry}/follow-up', [\App\Http\Controllers\Admin\InquiryController::class, 'updateFollowUp'])->name('inquiries.follow-up');
        Route::post('inquiries/bulk', [\App\Http\Controllers\Admin\InquiryController::class, 'bulkAction'])->name('inquiries.bulk');
        Route::resource('inquiries', \App\Http\Controllers\Admin\InquiryController::class)->except(['create', 'store', 'edit', 'update']);
        Route::get('locations/{location}/children', [\App\Http\Controllers\Admin\LocationController::class, 'getChildren'])->name('locations.children');
        Route::resource('locations', \App\Http\Controllers\Admin\LocationController::class);
        Route::resource('property-types', \App\Http\Controllers\Admin\PropertyTypeController::class);
        Route::resource('amenities', \App\Http\Controllers\Admin\AmenityController::class);
        Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export/csv', [\App\Http\Controllers\Admin\ReportController::class, 'exportCsv'])->name('reports.export.csv');
        Route::get('reports/print', [\App\Http\Controllers\Admin\ReportController::class, 'print'])->name('reports.print');
        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        
        Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
        Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');

        Route::get('homepage', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('homepage.index');
        Route::post('homepage', [\App\Http\Controllers\Admin\HomeController::class, 'update'])->name('homepage.update');

        Route::patch('menus/{menu}/toggle', [\App\Http\Controllers\Admin\MenuController::class, 'toggle'])->name('menus.toggle');
        Route::post('menus/reorder', [\App\Http\Controllers\Admin\MenuController::class, 'reorder'])->name('menus.reorder');
        Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class)->except(['create', 'show', 'edit']);

        Route::post('media/sync', [\App\Http\Controllers\Admin\MediaController::class, 'sync'])->name('media.sync');
        Route::resource('media', \App\Http\Controllers\Admin\MediaController::class)->only(['index', 'store', 'destroy']);

        Route::patch('testimonials/{testimonial}/toggle', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggle'])->name('testimonials.toggle');
        Route::patch('testimonials/{testimonial}/feature', [\App\Http\Controllers\Admin\TestimonialController::class, 'feature'])->name('testimonials.feature');
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except(['show']);

        Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        Route::get('notifications/{id}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('notifications/{id}/unread', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsUnread'])->name('notifications.unread');
    });
});
