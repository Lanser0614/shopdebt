<?php

namespace Database\Seeders;

use App\Models\Debt;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DebtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Debt::factory(30)->create();

        foreach(Product::all() as $product){
            $debt = Debt::query()->inRandomOrder()->take(rand(1,2))->pluck('id');
            $product->debts()->attach($debt, ['price' => rand(10, 100) . '000']);
        }
    }
}
