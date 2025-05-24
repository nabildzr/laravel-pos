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
            $table->integer('price');
            $table->string('image')->nullable();
            $table->string('sku')->unique();
            $table->integer('stock')->default(0);
            $table->boolean('is_discount')->default(false);
            $table->integer('discount')->nullable();
            $table->integer('after_discount_price')->nullable();
            $table->enum('discount_type', ['percent', 'amount'])->nullable();
            $table->string('unit');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->boolean('is_active')->default(false);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
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
