<?php

namespace Database\Seeders;

// Seeders

use App\Models\District;
use App\Models\Dish;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        $poblacion = District::where('name', 'Poblacion')->firstOrFail();

        // Hand-made eatery
        $handMadeName = 'Carinderia ni Buenviaje';
        $handMade = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => $handMadeName,
            'slug' => Str::slug($handMadeName),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $handMade->permit()->create([
            'permit_no' => 'DVO-2026-1111',
            'expires_on' => '2027-11-11',
        ]);

        $features = Feature::whereIn('name', ['Suki ni Buenviaje', 'Budget Meal'])->pluck('id');
        $handMade->features()->sync($features);

        $handMade->dishes()->createMany([
            [
                'name' => 'Tinolang Manok',
                'price' => 85.00,
                'is_bestseller' => true,
            ],
            [
                'name' => 'Kinilaw na Tuna',
                'price' => 120.00,
                'is_bestseller' => false,
            ],
            [
                'name' => 'Durian Shake',
                'price' => 75.00,
                'is_bestseller' => false,
            ],
        ]);

        // 14 Factory Eateries (11 open, 3 closed)
        $districts = District::all();
        $allFeatures = Feature::all();

        $openEateries = Eatery::factory()->count(11)->create();
        $closedEateries = Eatery::factory()->closed()->count(3)->create();
        $factoryEateries = $openEateries->concat($closedEateries);

        foreach ($factoryEateries as $index => $eatery) {
            // Assign random district
            $eatery->district_id = $districts->random()->id;
            $eatery->save();

            // At least one expired permit
            if ($index === 0) {
                $eatery->permit()->create([
                    'permit_no' => 'DVO-2026-100' . $index,
                    'expires_on' => '2025-01-15',
                ]);
            } else {
                $eatery->permit()->create([
                    'permit_no' => 'DVO-2026-10' . str_pad((string)($index + 10), 3, '0', STR_PAD_LEFT),
                    'expires_on' => '2027-08-20',
                ]);
            }

            // 2-5 dishes
            $dishCount = fake()->numberBetween(2, 5);
            Dish::factory()->count($dishCount)->for($eatery)->create();

            // 1-3 random features attached with attach()
            $featureSubset = $allFeatures->random(fake()->numberBetween(1, 3))->pluck('id');
            $eatery->features()->attach($featureSubset);
        }
    }
}
