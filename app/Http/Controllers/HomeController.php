<?php

namespace App\Http\Controllers;

// Controller

use App\Models\District;
use App\Models\Eatery;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $eateriesCount = Eatery::count();
        $districtsCount = District::count();
        $reviewsCount = Review::count();

        $topEateries = Eatery::with(['district', 'features'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->having('reviews_count', '>=', 1)
            ->orderByDesc('reviews_avg_rating')
            ->take(3)
            ->get();

        return view('home', compact('eateriesCount', 'districtsCount', 'reviewsCount', 'topEateries'));
    }
}
