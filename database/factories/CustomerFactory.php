<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FamilyContactPerson;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'family_contact_persons_id' => FamilyContactPerson::factory(),
            'amount_adults' => $this->faker->numberBetween(1, 5),
            'amount_children' => $this->faker->optional()->numberBetween(0, 5),
            'amount_babies' => $this->faker->optional()->numberBetween(0, 3),
            'special_wishes' => $this->faker->optional()->randomElement(['Geen varken', 'Gluten', 'Vegetarisch', 'Veganistisch', 'Geen noten', 'Geen zuivel']),
            'family_name' => fn(array $attributes) => FamilyContactPerson::find($attributes['family_contact_persons_id'])->last_name,
            'address' => $this->faker->streetName() . ' ' . $this->faker->buildingNumber(),
            'date_created' => $this->faker->dateTime(),
            'date_updated' => $this->faker->dateTime(),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
