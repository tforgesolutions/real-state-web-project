<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewable_type' => 'required|string|in:property,agent,agency',
            'reviewable_id' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'body' => 'required|string|min:10|max:2000',
            'review_context' => 'nullable|string|max:255',
        ]);

        // Optional: Check if user already reviewed this entity
        $existing = Review::where('user_id', Auth::id())
            ->where('reviewable_type', $validated['reviewable_type'])
            ->where('reviewable_id', $validated['reviewable_id'])
            ->first();

        if ($existing) {
            return back()->with('review_error', 'You have already reviewed this.');
        }

        Auth::user()->reviews()->create(array_merge($validated, ['status' => 'published']));

        return back()->with('review_success', 'Your review has been published successfully!');
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'body' => 'required|string|min:10|max:2000',
            'review_context' => 'nullable|string|max:255',
        ]);

        $review->update($validated);

        return back()->with('review_success', 'Your review has been updated successfully!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('review_success', 'Your review has been deleted.');
    }
}
