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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            // $table->string('member_id')->nullable();
            $table->dateTime('reservation_datetime');
            $table->time('completed_reservation_time')->nullable();
            $table->integer('down_payment_amount');
            $table->integer('guest_count');
            $table->enum('status', [
                'reserved',
                'occupied',
                'completed',
                'cancelled',
            ]);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
