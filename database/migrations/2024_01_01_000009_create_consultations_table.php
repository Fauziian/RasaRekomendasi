<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('chef_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained('chef_schedules')->cascadeOnDelete();
            $table->enum('status', ['pending', 'confirmed', 'ongoing', 'completed', 'cancelled'])
                ->default('pending')
                ->index();
            $table->text('topic')->nullable();                // User's consultation topic/question
            $table->text('chef_notes')->nullable();           // Chef's internal notes
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->integer('duration_minutes')->nullable();  // Actual duration
            $table->tinyInteger('user_rating')->unsigned()->nullable(); // Post-session rating 1-5
            $table->text('user_feedback')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['chef_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
