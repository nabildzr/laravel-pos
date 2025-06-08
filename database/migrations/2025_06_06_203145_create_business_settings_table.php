<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
           Schema::create('business_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('receipt_footer')->nullable();
            $table->string('tax_number')->nullable(); // NPWP atau nomor pajak
            $table->timestamps();
        });

        // default business data
        DB::table('business_settings')->insert([
            'name' =>  'Mini Cafe/Restaurant',
            'email' => 'info@example.com',
            'phone' => '123456789',
            'website' => 'https://example.com',
            'address' => 'Alamat Perusahaan',
            'receipt_footer' => 'Terima kasih atas kunjungan Anda',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_settings');
    }
};
