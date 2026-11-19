<?php

namespace Database\Factories;

use App\Models\Eatery;
use App\Models\Permit;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermitFactory extends Factory
{
    protected $model = Permit::class;

    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'permit_no' => 'DVO-2026-' . fake()->unique()->numberBetween(1000, 99999),
            'expires_on' => fake()->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_on' => fake()->dateTimeBetween('-1 year', '-1 day')->format('Y-m-d'),
        ]);
    }
}
