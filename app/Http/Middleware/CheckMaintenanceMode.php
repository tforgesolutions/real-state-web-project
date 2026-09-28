<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled
        if (Setting::get('maintenance_mode') == '1') {
            // Allow access to admin panel routes
            if (!$request->is('admin/*') && !$request->is('login') && !$request->is('logout')) {
                return response()->view('errors.maintenance', [
                    'message' => Setting::get('maintenance_message', 'We are currently performing scheduled maintenance. Please check back soon.')
                ], 503);
            }
        }

        return $next($request);
    }
}
