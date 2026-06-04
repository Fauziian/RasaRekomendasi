<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();           // RR-2024-00001
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vip_package_id')->constrained('vip_packages');
            $table->decimal('amount', 12, 2);
            $table->enum('payment_status', ['pending', 'success', 'failed', 'expired', 'refunded'])
                ->default('pending')
                ->index();
            $table->string('payment_method')->nullable();         // "transfer_bank", "qris", "ewallet"
            $table->string('payment_channel')->nullable();        // "BCA", "Mandiri", "GoPay"
            $table->json('payment_gateway_log')->nullable();      // Raw response from payment gateway
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->text('notes')->nullable();

            // VIP activation window
            $table->timestamp('vip_starts_at')->nullable();
            $table->timestamp('vip_ends_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'payment_status']);
            $table->index(['payment_status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
