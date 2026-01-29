<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ========================================
 * MIGRATION: Payments Table
 * Fungsi: Menyimpan data pembayaran order
 * ========================================
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Primary key
            
            // Relasi ke orders
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade'); // Jika order dihapus, payment ikut terhapus
            
            // Data pembayaran
            $table->decimal('amount', 12, 2); // Jumlah yang dibayar
            
            // Metode pembayaran: bank_transfer, e_wallet, cod, cash
            $table->enum('payment_method', ['bank_transfer', 'e_wallet', 'cod', 'cash'])
                  ->default('bank_transfer');
            
            // Status pembayaran: pending, verified, rejected
            $table->enum('status', ['pending', 'verified', 'rejected'])
                  ->default('pending');
            
            // Bukti pembayaran (foto transfer)
            $table->string('proof_image')->nullable(); // Path ke gambar bukti transfer
            
            // Detail payment
            $table->string('bank_name')->nullable(); // Nama bank (BCA, Mandiri, dll)
            $table->string('account_name')->nullable(); // Nama rekening pengirim
            $table->string('account_number')->nullable(); // Nomor rekening pengirim
            
            // Nomor referensi/transaksi (opsional)
            $table->string('reference_number')->nullable();
            
            // Catatan dari customer
            $table->text('notes')->nullable();
            
            // Catatan admin (misal: alasan reject)
            $table->text('admin_notes')->nullable();
            
            // Siapa yang verifikasi (admin)
            $table->foreignId('verified_by')->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            
            // Waktu verifikasi
            $table->timestamp('verified_at')->nullable();
            
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};