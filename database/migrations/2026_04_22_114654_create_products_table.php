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
            // UUID Primary Key
            $table->uuid('id')->primary();

            // SKU
            $table->string('sku')->unique();

            // Name
            $table->string('name');

            // Description
            $table->text('description')->nullable();

            // Price
            $table->decimal('price', 10, 2);

            // Stock
            $table->integer('stock_quantity')->default(0);

            // Threshold
            $table->integer('low_stock_threshold')->default(10);

            // Status
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active');

            // Timestamps
            $table->timestamps();

            // Soft Delete
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('stock_quantity');
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
