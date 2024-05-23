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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->bigInteger('total_amount');
            $table->text('notes',1000)->nullable();
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->bigInteger('total_discount')->nullable();
            $table->unsignedBigInteger('payment_method_id');
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('order_number_id')->nullable();
            $table->timestamp('order_date')->useCurrent();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('voucher_id')->references('id')->on('vouchers');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('order_number_id')->references('id')->on('order_numbers');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
