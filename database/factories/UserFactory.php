<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $guestRoleId = Role::where('role_name', 'Guest')->value('id');

        return [
            'role_id' => $guestRoleId,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => $this->faker->dateTime(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'date_created' => $this->faker->dateTime(),
            'date_updated' => $this->faker->dateTime(),
            'is_active' => $this->faker->boolean(90),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
