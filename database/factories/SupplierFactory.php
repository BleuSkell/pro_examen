<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContactPerson;
use App\Models\Supplier;    


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_person_id' => ContactPerson::factory(),
            'company_name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'next_delivery_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'next_delivery_time' => $this->faker->time(),
            'date_created' => $this->faker->dateTime(),
            'date_updated' => $this->faker->dateTime(),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
