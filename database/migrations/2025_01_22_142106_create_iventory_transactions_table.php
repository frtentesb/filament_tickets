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
        Schema::create('iventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->primary();
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('category');
            $table->string('manufacturer');
            $table->double('sale_price');
            $table->date('date_sale');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iventory_transactions');
    }
};
