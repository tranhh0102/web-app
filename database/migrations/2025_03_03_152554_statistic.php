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
        Schema::create('statistic', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('income')->default(0);
            $table->integer('expense')->default(0);
            $table->integer('goal')->default(0);
            $table->integer('charity')->default(0);
            $table->json('income_info')->nullable();
            $table->json('expense_info')->nullable();
            $table->json('goal_info')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic');
    }
};
