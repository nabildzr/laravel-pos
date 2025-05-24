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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->text('description');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        /**
         * Membalik migrasi untuk tabel `products`.
         *
         * Bagian ini dari migrasi menghapus constraint foreign key 
         * dan kolom `category_id` dari tabel `products`. 
         * Biasanya digunakan untuk membatalkan perubahan yang dibuat di metode `up` 
         * di mana kolom `category_id` dan hubungan foreign key-nya ditambahkan.
         *
         * Langkah-langkah yang dilakukan:
         * - Menghapus constraint foreign key pada kolom `category_id`.
         * - Menghapus kolom `category_id` dari tabel `products`.
         *
         * Ini memastikan bahwa skema database dikembalikan ke keadaan sebelumnya 
         * sebelum metode `up` diterapkan.
         */

       

        Schema::dropIfExists('categories');
    }
};
