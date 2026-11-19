<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    protected $model = Dish::class;

    public function definition(): array
    {
        $dishes = [
            'Pork Humba', 'Beef Bulalo', 'Sinigang na Hipon', 'Chicken Inasal',
            'Bicol Express', 'Adobong Kangkong', 'Pancit Canton', 'Halo-Halo Special',
            'Crispy Pata', 'Kare-Kare', 'Chicharron Bulaklak', 'Tuna Panga'
        ];

        return [
            'eatery_id' => Eatery::factory(),
            'name' => fake()->randomElement($dishes),
            'price' => fake()->randomFloat(2, 45, 250),
            'is_bestseller' => false,
        ];
    }
}
