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
        $prenums = ['90','91','93','94','95','97','98','99','50','88','77','33','20'];
        return [
            'shop_id' => $shops->id,
            'name' => $this->faker->userName,
            'phone_number' => '+998'.$prenums[array_rand($prenums)].rand(0000001,9999999),
            'address' => $this->faker->address
        ];
    }
}
