<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vip_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');                           // "Paket Bulanan", "Paket Tahunan"
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('duration_days')->unsigned();     // 30, 90, 365
            $table->json('features')->nullable();             // ["Akses Video Tutorial","Konsultasi Chef",...]
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vip_packages');
    }
};
