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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // primary key
            // relasi ke user
            $table->foreignId('user_id')
                    ->constrained('users')
                    ->onDelete('cascade');
            // inv/2026/01/12
            $table->string('invoice_number')->unique();
            // total pembayaran
            $table->decimal('total', 12, 2);
            // status order: pending, processing, shipped, completed, canceled
            $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'canceled'])->default('pending');
            // metode pembayaran? cash, transfer, cod
            $table->enum('payment_method', ['cash', 'transfer', 'cod'])->default('cash');
            // alamat pembayarna
            $table->text('shipping_address');
            // catatan customer
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
