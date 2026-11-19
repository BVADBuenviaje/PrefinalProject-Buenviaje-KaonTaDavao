<?php

namespace App\Http\Controllers;

// Controller

use App\Http\Requests\StoreReviewRequest;
use App\Models\Eatery;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Eatery $eatery)
    {
        $validated = $request->validated();

        $eatery->reviews()->create($validated);

        return redirect()->route('eateries.show', $eatery)->with('success', 'Salamat! Review posted.');
    }

    public function destroy(Review $review)
    {
        $eatery = $review->eatery;
        $review->delete();

        return redirect()->route('eateries.show', $eatery)->with('success', 'Review deleted.');
    }
}
