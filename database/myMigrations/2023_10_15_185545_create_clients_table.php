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
        Schema::connection('myMysql')->create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id');
            $table->string('name');
            $table->unsignedBigInteger('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('balance')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('myMysql')->dropIfExists('clients');
    }
};
