<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductCategory;
use App\Models\Supplier;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_category_id' => ProductCategory::factory(),
            'supplier_id' => Supplier::factory(),
            'product_name' => $this->faker->word(),
            'barcode' => $this->faker->unique()->ean13(),
            'date_created' => $this->faker->dateTime(),
            'date_updated' => $this->faker->dateTime(),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
