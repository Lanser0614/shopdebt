<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prenums = ['90','91','93','94','95','97','98','99','50','88','77','33','20'];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make(Str::random(10)),
            'remember_token' => Str::random(10),
            'phone_number' => '+998'.$prenums[array_rand($prenums)].rand(1111111,9999999)
        ];
    }
}
