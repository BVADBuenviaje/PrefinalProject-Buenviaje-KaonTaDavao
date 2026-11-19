<?php

namespace App\Http\Controllers;

// Controller

use App\Models\Eatery;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Eatery $eatery)
    {
        // Handled via StoreReviewRequest in Milestone 6
        return redirect()->route('eateries.show', $eatery)->with('success', 'Salamat! Review posted.');
    }

    public function destroy(Review $review)
    {
        $eatery = $review->eatery;
        $review->delete();

        return redirect()->route('eateries.show', $eatery)->with('success', 'Review deleted.');
    }
}
