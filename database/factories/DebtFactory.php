<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Debt>
 */
class DebtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shops = Shop::query()->inRandomOrder()->first();
        $clients = Client::query()->inRandomOrder()->first();

        return [
            'shop_id' => $shops->id,
            'client_id' => $clients->id,
            'comment' => $this->faker->sentence(),
            'amount' => $this->faker->numberBetween(100, 300) . '000',
            'deadline' => $this->faker->dateTimeBetween('+1 week', '+1 month')
        ];
    }
}
