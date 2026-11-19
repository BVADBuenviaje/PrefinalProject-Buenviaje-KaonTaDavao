<?php

namespace Database\Seeders;

// Seeders

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $handMade = Eatery::where('slug', 'carinderia-ni-buenviaje')->firstOrFail();
        $tita = User::where('email', 'tita.buenviaje@kaonta.test')->firstOrFail();
        $brian = User::where('email', 'buenviaje@kaonta.test')->firstOrFail();
        $otherUsers = User::whereNotIn('id', [$tita->id, $brian->id])->get();

        // Specific review by Tita Buenviaje
        $handMade->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Buenviaje.',
        ]);

        // Additional reviews on hand-made eatery (at least 3 total)
        $handMade->reviews()->create([
            'user_id' => $brian->id,
            'rating' => 5,
            'body' => 'Kalami sa Tinolang Manok diri! Authentic Davao carinderia experience.',
        ]);

        $randomUser = $otherUsers->first();
        if ($randomUser) {
            $handMade->reviews()->create([
                'user_id' => $randomUser->id,
                'rating' => 4,
                'body' => 'Dili kamahayan ang pag-kaon diri, limpyo ug maayo ang serbisyo.',
            ]);
        }

        // Factory eateries reviews
        $allUsers = User::all();
        $openEateries = Eatery::where('id', '!=', $handMade->id)
            ->where('is_open', true)
            ->get();

        foreach ($openEateries as $eatery) {
            $reviewCount = fake()->numberBetween(0, 6);
            if ($reviewCount > 0) {
                $reviewers = $allUsers->random(min($reviewCount, $allUsers->count()));
                foreach ($reviewers as $reviewer) {
                    $eatery->reviews()->create([
                        'user_id' => $reviewer->id,
                        'rating' => fake()->numberBetween(1, 5),
                        'body' => fake()->randomElement([
                            'Lami kaayo ang sabaw og init pa gyud pag-serve!',
                            'Sulit kaayo ang serving sizes, balik mi sunod semana.',
                            'Barato na, limpyo pa gyud ang palibot. Recommended!',
                            'Affordable eatery with delicious local viands.',
                            'Best carinderia experience in Davao City! 5 stars.',
                            'Friendly staff and fresh food choices every day.',
                        ]),
                    ]);
                }
            }
        }
        // Closed eateries get 0 reviews (none added)
    }
}
