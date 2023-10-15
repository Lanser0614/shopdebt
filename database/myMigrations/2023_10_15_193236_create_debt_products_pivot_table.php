<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('myMysql')->create('debt_products_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('debt_id')->constrained('debts');
            $table->json('product_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('myMysql')->dropIfExists('debt_products_pivot');
    }
};
