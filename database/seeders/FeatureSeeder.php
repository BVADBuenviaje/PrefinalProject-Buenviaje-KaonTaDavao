<?php

namespace Database\Seeders;

// Seeders

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            'Suki ni Buenviaje',
            'Budget Meal',
            'Halal',
            'Open 24 Hours',
            'Aircon',
            'Free Sabaw',
        ];

        foreach ($features as $name) {
            Feature::create(['name' => $name]);
        }
    }
}
