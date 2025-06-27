<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoodPackage>
 */
class FoodPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'package_number' => 'P-' . $this->faker->unique()->numberBetween(10000, 99999),
            'date_composed' => $this->faker->dateTime(),
            'date_issued' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'date_created' => $this->faker->dateTime(),
            'date_updated' => $this->faker->dateTime(),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
