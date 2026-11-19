<?php

namespace Database\Seeders;

// Seeders

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DistrictSeeder::class,
            FeatureSeeder::class,
            UserSeeder::class,
            EaterySeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
