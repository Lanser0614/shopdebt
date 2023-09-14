<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ShopSeeder::class,
            SellerSeeder::class,
            ClientSeeder::class,
            ProductSeeder::class,
            DebtSeeder::class,
            ContactSeeder::class
        ]);
    }
}
