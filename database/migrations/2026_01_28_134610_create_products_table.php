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
            $table->engine = 'InnoDB';
            $table->id(); // Primary key
            // Relasi ke categories
            $table->foreignid('category_id')
                    ->constrained('categories')
                    ->onDelete('cascade'); // Jika kategori dihapus, produk ikut terhapus
            $table->string('name', 150); // Nama produk (Kopi Aceh Gayo)
            $table->string('slug')->unique(); // URL slug (kopi-aceh-gayo)
            $table->string('description')->nullable(); // Deskripsi lengkap produk
            $table->decimal('price', 10,2); // Harga (max 99,999,999.99)
            $table->integer('stock')->default(0); // Jumlah stock
            $table->string('image')->nullable(); // Path gambar produk
        $table->boolean('is_active')->default(true); // Status publish
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
