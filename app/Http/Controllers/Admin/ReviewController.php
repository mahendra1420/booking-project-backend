<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['user', 'business'])->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function hide(Review $review)
    {
        $review->is_approved = ! $review->is_approved;
        $review->save();

        $status = $review->is_approved ? 'visible' : 'hidden';

        return redirect()->back()->with('success', "Review marked as {$status}.");
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
