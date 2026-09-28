<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $location = $request->get('location', 'header');
        
        $menuItems = MenuItem::where('location', $location)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
            
        $parentOptions = MenuItem::where('location', $location)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        return view('admin.menus.index', compact('menuItems', 'location', 'parentOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'location' => 'required|string|in:header,footer',
            'parent_id' => 'nullable|exists:menu_items,id',
            'target' => 'required|string|in:_self,_blank',
        ]);

        if ($validated['parent_id']) {
            // Check if parent exists and is in the same location
            $parent = MenuItem::find($validated['parent_id']);
            if ($parent->location !== $validated['location']) {
                return redirect()->back()->withErrors(['parent_id' => 'Parent must belong to the same menu location.']);
            }
        }

        $maxOrder = MenuItem::where('location', $validated['location'])
            ->where('parent_id', $validated['parent_id'])
            ->max('order');
            
        $validated['order'] = $maxOrder ? $maxOrder + 1 : 0;
        $validated['is_active'] = $request->has('is_active');

        MenuItem::create($validated);
        
        Cache::forget('menu_' . $validated['location']);

        return redirect()->back()->with('success', 'Menu item added successfully.');
    }

    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'target' => 'required|string|in:_self,_blank',
        ]);

        if ($validated['parent_id'] == $menu->id) {
            return redirect()->back()->withErrors(['parent_id' => 'Menu item cannot be its own parent.']);
        }

        if ($validated['parent_id']) {
            // Prevent circular nesting
            $parent = MenuItem::find($validated['parent_id']);
            if ($parent->parent_id == $menu->id) {
                return redirect()->back()->withErrors(['parent_id' => 'Circular parent relationships are not allowed.']);
            }
            if ($parent->location !== $menu->location) {
                return redirect()->back()->withErrors(['parent_id' => 'Parent must belong to the same menu location.']);
            }
        }

        $validated['is_active'] = $request->has('is_active');

        $menu->update($validated);
        
        Cache::forget('menu_' . $menu->location);

        return redirect()->back()->with('success', 'Menu item updated successfully.');
    }

    public function destroy(MenuItem $menu)
    {
        $location = $menu->location;
        $menu->delete();
        Cache::forget('menu_' . $location);
        
        return redirect()->back()->with('success', 'Menu item deleted successfully.');
    }

    public function toggle(MenuItem $menu)
    {
        $menu->is_active = !$menu->is_active;
        $menu->save();
        Cache::forget('menu_' . $menu->location);
        
        return redirect()->back()->with('success', 'Menu status updated.');
    }

    public function reorder(Request $request)
    {
        $items = $request->input('items', []);
        
        foreach ($items as $item) {
            MenuItem::where('id', $item['id'])->update(['order' => $item['order']]);
        }
        
        if (count($items) > 0) {
            $menu = MenuItem::find($items[0]['id']);
            if ($menu) {
                Cache::forget('menu_' . $menu->location);
            }
        }
        
        return response()->json(['success' => true]);
    }
}
