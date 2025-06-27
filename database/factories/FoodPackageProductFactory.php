<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FoodPackage;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoodPackageProduct>
 */
class FoodPackageProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'food_package_id' => FoodPackage::factory(),
            'product_id' => Product::factory(),
            'amount' => $this->faker->numberBetween(1, 100),
            'date_created' => now(),
            'date_updated' => now(),
            'is_active' => true,
        ];
    }
}
