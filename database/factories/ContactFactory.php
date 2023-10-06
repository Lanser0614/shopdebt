<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::query()->inRandomOrder()->first();
        $prenums = ['90','91','93','94','95','97','98','99','50','88','77','33','20'];

        return [
            'user_id' => $users->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => '+998'.$prenums[array_rand($prenums)].rand(1111111,9999999)
        ];
    }
}
