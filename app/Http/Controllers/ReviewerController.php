<?php

namespace App\Http\Controllers;

// Controller

use App\Models\User;

class ReviewerController extends Controller
{
    public function show(User $user)
    {
        $user->load([
            'reviews' => fn ($query) => $query
                ->latest()
                ->with(['eatery.district', 'eatery.features']),
        ]);

        $reviewsCount = $user->reviews()->count();

        return view('reviewers.show', compact('user', 'reviewsCount'));
    }
}
