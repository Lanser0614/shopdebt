<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shops = Shop::query()->inRandomOrder()->first();
        return [
            'shop_id' => $shops->id,
            'name' => $this->faker->userName,
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address
        ];
    }
}
