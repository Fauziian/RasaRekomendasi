<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            // Preferred food category IDs: [1, 3, 5]
            $table->json('preferred_category_ids')->nullable();

            // Allergen list to exclude: ["gluten","dairy","nuts","seafood","eggs"]
            $table->json('allergies')->nullable();

            // Available ingredients the user has: ["ayam","bawang","tomat"]
            $table->json('available_ingredients')->nullable();

            // Max cooking time willing to spend (in minutes)
            $table->integer('cooking_time_limit')->unsigned()->default(60);

            // Difficulty preference: 'easy' | 'medium' | 'hard' | 'any'
            $table->enum('preferred_difficulty', ['easy', 'medium', 'hard', 'any'])->default('any');

            // Calorie limit per serving
            $table->integer('calorie_limit')->unsigned()->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
