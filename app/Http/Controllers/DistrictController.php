<?php

namespace App\Http\Controllers;

// Controller

use App\Models\District;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::withCount('eateries')
            ->orderBy('name')
            ->get();

        return view('districts.index', compact('districts'));
    }

    public function show(District $district)
    {
        $district->load([
            'eateries' => fn ($query) => $query
                ->with(['district', 'features'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->orderBy('name'),
        ]);

        $reviewsCount = $district->reviews()->count();

        return view('districts.show', compact('district', 'reviewsCount'));
    }
}
