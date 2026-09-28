<?php
$content = file_get_contents('routes/web.php');
// Strip out the broken part and append correctly
$clean = substr($content, 0, strpos($content, '// Admin Routes'));
// If it's broken, strpos might not find it, let's just find the last correct route
$pos = strpos($content, "return view('agencies.show', compact('agency'));\r\n})->name('agencies.show');");
if ($pos !== false) {
    $clean = substr($content, 0, $pos + 82); // adjust length to keep the route
} else {
    // fallback, just find agencies.show');
    $pos = strpos($content, "agencies.show');");
    $clean = substr($content, 0, $pos + 17);
}

$admin_routes = "

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
        Route::get('properties', function() { return view('admin.placeholder', ['module' => 'Properties']); })->name('properties.index');
        Route::get('projects', function() { return view('admin.placeholder', ['module' => 'Projects']); })->name('projects.index');
        Route::get('agents', function() { return view('admin.placeholder', ['module' => 'Agents']); })->name('agents.index');
        Route::get('users', function() { return view('admin.placeholder', ['module' => 'Users']); })->name('users.index');
        Route::get('inquiries', function() { return view('admin.placeholder', ['module' => 'Inquiries']); })->name('inquiries.index');
        Route::get('locations', function() { return view('admin.placeholder', ['module' => 'Locations']); })->name('locations.index');
        Route::get('property-types', function() { return view('admin.placeholder', ['module' => 'Property Types']); })->name('property-types.index');
        Route::get('amenities', function() { return view('admin.placeholder', ['module' => 'Amenities']); })->name('amenities.index');
        Route::get('reports', function() { return view('admin.placeholder', ['module' => 'Reports']); })->name('reports.index');
        Route::get('settings', function() { return view('admin.placeholder', ['module' => 'Settings']); })->name('settings.index');
    });
});
";

file_put_contents('routes/web.php', $clean . "\n" . $admin_routes);
echo "Fixed!\n";
