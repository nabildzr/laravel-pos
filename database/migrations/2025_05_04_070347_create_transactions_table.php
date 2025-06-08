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
            $table->string('member_id')->nullable();
            $table->string('cashier')->nullable();
            $table->integer('total_amount');
            $table->enum('status', [
                'pending',
                'paid',
                'cancelled'
            ]);
            $table->string('note')->nullable();
            $table->integer('return_amount')->nullable();
            $table->integer('paid_amount')->nullable();
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
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
