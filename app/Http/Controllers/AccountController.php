<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.index');
    }

    public function profile()
    {
        return view('account.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Profile updated successfully']);
        }

        return back()->with('status', 'Profile updated!');
    }

    public function favorites()
    {
        return view('account.favorites');
    }

    public function compare()
    {
        return view('account.compare');
    }

    public function inquiries()
    {
        return view('account.inquiries');
    }

    public function recentlyViewed()
    {
        return view('account.recently-viewed');
    }

    public function settings()
    {
        return view('account.settings', [
            'user' => Auth::user(),
        ]);
    }
}
