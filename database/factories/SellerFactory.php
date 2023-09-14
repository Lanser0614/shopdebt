<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::query()->inRandomOrder()->first();
        $shops = Shop::query()->inRandomOrder()->first();
        return [
            'user_id' => $users->id,
            'shop_id' => $shops->id,
            'label' => $this->faker->word,
            'activation_code' => $this->faker->numberBetween(),
            'is_activated' => true
        ];
    }
}
