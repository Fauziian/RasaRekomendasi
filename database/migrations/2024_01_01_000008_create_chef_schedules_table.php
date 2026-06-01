<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chef_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chef_id')->constrained('users')->cascadeOnDelete();
            $table->date('available_date');
            $table->time('available_time_start');
            $table->time('available_time_end');
            $table->enum('status', ['available', 'booked', 'cancelled'])->default('available')->index();
            $table->text('notes')->nullable();       // e.g., "Specializing in Indonesian cuisine this session"
            $table->integer('max_bookings')->default(1); // Allow group sessions in future
            $table->integer('current_bookings')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['chef_id', 'available_date', 'status']);
            $table->index(['available_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chef_schedules');
    }
};
