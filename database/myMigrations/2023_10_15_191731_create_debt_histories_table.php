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
        Schema::connection('myMysql')->create('debt_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('debt_id')->nullable();
            $table->foreignId('client_id');
            $table->bigInteger('amount');
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('myMysql')->dropIfExists('debt_histories');
    }
};
