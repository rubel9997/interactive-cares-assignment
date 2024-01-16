<?php

namespace Database\Factories;

use App\Constants\Role;
use App\Constants\Status;
use App\Models\VaccineCenter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        return [
            'vaccine_center_id' => VaccineCenter::inRandomOrder()->pluck('id')->first(),
            'name' => $this->faker->name(),
            'nid' => $this->faker->unique()->numberBetween(1000000000, 2000000000),
            'phone' => $this->faker->phoneNumber(),
            'role' => Role::USER,
            'status' => fake()->randomElement(Status::vaccineStatusList()),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
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
