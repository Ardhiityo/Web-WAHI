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
            $table->unsignedBigInteger('grandtotal_purchase_amount');
            $table->unsignedBigInteger('total_discount');
            $table->unsignedBigInteger('subtotal_selling_amount');
            $table->unsignedBigInteger('grandtotal_selling_amount');
            $table->bigInteger('profit_amount');
            $table->enum('transaction_status', ['pending', 'paid', 'cancel', 'expired']);
            $table->enum('transaction_type', ['cashless', 'cash']);
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
