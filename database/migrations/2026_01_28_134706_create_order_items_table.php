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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // primary key
            // relasi ke orders
            $table->foreignId('order_id')
                    ->constrained('orders')
                    ->onDelete('cascade'); 
            // relasi ke products
            $table->foreignId('product_id')
                    ->constrained('products')
                    ->onDelete('cascade'); 

            $table->integer('quantity'); // jumlah harga dipesan
            $table->decimal('price', 10, 2); // harga satuan saat diorder
            $table->decimal('subtotal', 12, 2); // quantity * price
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
