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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('proof');
            $table->integer('amount');
            $table->text('description');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            // $table->text('rejection_reason')->nullable(); // nanti ajah (masih sederhana & secepatnya)
            $table->timestamp('approved_at')->nullable()->default(null);
            $table->foreignId('created_by')->constrained('users');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
