<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chef_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');

            // Ingredients stored as JSON array: [{"name":"Bawang Merah","amount":"3","unit":"siung"}, ...]
            $table->json('ingredients');

            // Steps stored as JSON array: [{"step":1,"instruction":"...","image":"..."}, ...]
            $table->json('cooking_steps');

            // Nutrition & meta
            $table->integer('prep_time')->unsigned()->comment('Minutes');
            $table->integer('cook_time')->unsigned()->comment('Minutes');
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium')->index();
            $table->integer('calories')->unsigned()->nullable();
            $table->integer('servings')->unsigned()->default(2);

            // Media
            $table->string('image')->nullable();
            $table->string('video_url')->nullable()->comment('VIP-only video tutorial URL');
            $table->boolean('is_vip_content')->default(false)->index();

            // Allergen tags stored as JSON array: ["gluten","nuts","dairy", ...]
            $table->json('allergens')->nullable();

            // Status
            $table->enum('status', ['draft', 'published', 'archived'])->default('published')->index();

            // Aggregated stats (updated via observers)
            $table->decimal('rating_avg', 3, 2)->default(0.00);
            $table->unsignedInteger('rating_count')->default(0);
            $table->unsignedInteger('view_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Full-text search index
            $table->index(['title', 'status']);
            $table->index(['chef_id', 'status']);
            $table->index(['category_id', 'is_vip_content']);
            $table->index(['difficulty', 'prep_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
