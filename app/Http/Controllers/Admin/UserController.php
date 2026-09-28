<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:255',
            'role' => 'required|in:admin,user,agent',
            'status' => 'required|in:active,inactive,suspended',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|max:2048'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('users', 'public');
        }

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:255',
            'role' => 'required|in:admin,user,agent',
            'status' => 'required|in:active,inactive,suspended',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|max:2048'
        ]);

        // Admin Protection Checks
        if ($user->id === Auth::id()) {
            if ($validated['status'] !== 'active' && $user->status === 'active') {
                return back()->with('error', 'You cannot disable or suspend your own account.');
            }
            if ($validated['role'] !== 'admin' && $user->role === 'admin') {
                return back()->with('error', 'You cannot remove your own admin privileges.');
            }
        }
        
        if ($user->role === 'admin' && $validated['role'] !== 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot change role. This is the only remaining admin account.');
            }
        }
        
        if ($user->role === 'admin' && $validated['status'] !== 'active') {
            if ($user->id !== Auth::id()) {
                $adminCount = User::where('role', 'admin')->where('status', 'active')->count();
                if ($adminCount <= 1) {
                    return back()->with('error', 'Cannot disable this account. This is the only remaining active admin account.');
                }
            }
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('users', 'public');
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }

        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('admin.users.index')->with('error', 'Cannot delete the only remaining admin account.');
            }
        }
        
        if ($user->properties()->count() > 0) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete user because they have assigned properties. Please reassign or delete the properties first.');
        }
        
        if ($user->reviews()->count() > 0 || $user->propertyAlerts()->count() > 0) {
            // Alternatively, we can let soft deletes handle this if DB uses cascade. But safe to block or delete related.
            // Since we soft delete users (Wait, User doesn't use SoftDeletes currently, let's just delete or warn).
            // Actually, we'll let it proceed for reviews/alerts if they cascade on delete, which they do in migration.
            // But properties are critical.
        }

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
    
    public function removePhoto(Request $request, User $user)
    {
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
            $user->save();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
}
