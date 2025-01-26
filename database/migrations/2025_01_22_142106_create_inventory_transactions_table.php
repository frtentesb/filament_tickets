<?php

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Inventory::class)->constrained()->cascadeOnDelete();
            $table->string('movement_type');
            $table->decimal('sale_price')->nullable();
            $table->timestamp('date_sale')->nullable();
            $table->decimal('purchase_price')->nullable();
            $table->timestamp('date_purchase')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
