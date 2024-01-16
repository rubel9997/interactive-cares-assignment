<?php

namespace Database\Seeders;

use App\Constants\Role;
use App\Constants\Status;
use App\Models\User;
use App\Models\VaccineCenter;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            'vaccine_center_id' => VaccineCenter::inRandomOrder()->pluck('id')->first(),
            'name' => 'admin',
            'nid' => fake()->unique()->numberBetween(1000000000, 2000000000),
            'phone' => fake()->phoneNumber(),
            'email' => 'admin@test.com',
            'role' => Role::ADMIN,
            'status' => Status::NOT_VACCINATED,
        ]);

        User::factory()->times(500)->create([
            'role' => Role::USER,
        ]);
    }
}
