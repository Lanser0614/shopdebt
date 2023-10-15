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
        Schema::connection('myMysql')->create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_from_id')->references('id')->on('users');
            $table->foreignId('client_id');
            $table->string('comment');
            $table->unsignedBigInteger('amount');
            $table->dateTime('date');
            $table->dateTime('deadline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('myMysql')->dropIfExists('debts');
    }
};
