<?php

namespace Database\Factories;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        $comments = [
            'Lami kaayo ang sabaw og init pa gyud pag-serve!',
            'Sulit kaayo ang serving sizes, balik mi sunod semana.',
            'Barato na, limpyo pa gyud ang palibot. Recommended!',
            'Affordable eatery with delicious local viands.',
            'Best carinderia experience in Davao City! 5 stars.',
            'Friendly staff and fresh food choices every day.',
        ];

        return [
            'eatery_id' => Eatery::factory(),
            'user_id' => User::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'body' => fake()->randomElement($comments),
        ];
    }
}
