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
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();
            $table->foreignId('transaction_id')
                ->constrained('transactions')
                ->cascadeOnDelete();
            $table->primary(['product_id', 'transaction_id']);
            $table->unsignedBigInteger('unit_purchase_price');
            $table->unsignedBigInteger('grandtotal_purchase_amount');
            $table->unsignedBigInteger('unit_selling_price');
            $table->unsignedBigInteger('subtotal_selling_amount');
            $table->unsignedBigInteger('total_discount');
            $table->unsignedBigInteger('grandtotal_selling_amount');
            $table->bigInteger('profit_amount');
            $table->unsignedBigInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transactions');
    }
};
