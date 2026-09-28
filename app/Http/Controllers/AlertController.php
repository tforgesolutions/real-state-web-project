<?php

namespace App\Http\Controllers;

use App\Models\PropertyAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Auth::user()->propertyAlerts()->latest()->get();
        return view('account.alerts.index', compact('alerts'));
    }

    public function create(Request $request)
    {
        return view('account.alerts.create', ['request' => $request]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'transaction_type' => 'nullable|string|in:buy,rent',
            'property_type' => 'nullable|string',
            'location' => 'nullable|string',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|gte:min_price',
            'min_bedrooms' => 'nullable|integer|min:0',
            'max_bedrooms' => 'nullable|integer|gte:min_bedrooms',
            'min_bathrooms' => 'nullable|integer|min:0',
            'max_bathrooms' => 'nullable|integer|gte:min_bathrooms',
            'min_area' => 'nullable|numeric|min:0',
            'max_area' => 'nullable|numeric|gte:min_area',
            'frequency' => 'required|string|in:instant,daily,weekly',
        ]);

        Auth::user()->propertyAlerts()->create($validated);

        return redirect()->route('account.alerts.index')->with('status', 'Alert created successfully!');
    }

    public function edit(PropertyAlert $alert)
    {
        if ($alert->user_id !== Auth::id()) abort(403);
        return view('account.alerts.edit', compact('alert'));
    }

    public function update(Request $request, PropertyAlert $alert)
    {
        if ($alert->user_id !== Auth::id()) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'transaction_type' => 'nullable|string|in:buy,rent',
            'property_type' => 'nullable|string',
            'location' => 'nullable|string',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|gte:min_price',
            'min_bedrooms' => 'nullable|integer|min:0',
            'max_bedrooms' => 'nullable|integer|gte:min_bedrooms',
            'min_bathrooms' => 'nullable|integer|min:0',
            'max_bathrooms' => 'nullable|integer|gte:min_bathrooms',
            'min_area' => 'nullable|numeric|min:0',
            'max_area' => 'nullable|numeric|gte:min_area',
            'frequency' => 'required|string|in:instant,daily,weekly',
        ]);

        $alert->update($validated);

        return redirect()->route('account.alerts.index')->with('status', 'Alert updated successfully!');
    }

    public function toggleStatus(PropertyAlert $alert)
    {
        if ($alert->user_id !== Auth::id()) abort(403);
        $alert->update(['status' => $alert->status === 'active' ? 'paused' : 'active']);
        return back()->with('status', 'Alert status updated!');
    }

    public function destroy(PropertyAlert $alert)
    {
        if ($alert->user_id !== Auth::id()) abort(403);
        $alert->delete();
        return back()->with('status', 'Alert deleted.');
    }

    public function show(PropertyAlert $alert)
    {
        if ($alert->user_id !== Auth::id()) abort(403);
        return view('account.alerts.show', compact('alert'));
    }
}
