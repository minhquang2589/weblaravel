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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 255);
            $table->text('description') -> default(null);
            $table->bigInteger('price');
            $table->unsignedBigInteger('cate_id');
            $table->unsignedBigInteger('detail_id');
            $table->unsignedBigInteger('sales_count')->default(0);
            $table->boolean('is_new')->default(false);
            $table->foreign('cate_id')->references('id')->on('product_cates')->onDelete('cascade');
            $table->foreign('detail_id')->references('id')->on('product_details')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
