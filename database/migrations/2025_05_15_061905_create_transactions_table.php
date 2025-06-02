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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique();
            $table->unsignedBigInteger('discount');
            $table->unsignedBigInteger('discount_percentage')->nullable();
            $table->unsignedBigInteger('subtotal_amount');
            $table->unsignedBigInteger('total_amount');
            $table->enum('transaction_status', ['pending', 'paid']);
            $table->enum('transaction_type', ['cashless', 'cash']);
            $table->foreignId('voucher_id')->nullable()
                ->constrained('vouchers')->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
