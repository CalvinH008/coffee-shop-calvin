<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ========================================
 * MODEL: OrderItem
 * Fungsi: Mengelola detail item dalam order
 * Tabel: order_items
 * ========================================
 */

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */

    protected $table = 'order_items';

    /**
     * Field yang boleh diisi (mass assignment)
     */

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal'
    ];

    /**
     * Field yang akan di-cast ke tipe data tertentu
     */

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    /**
     * ========================================
     * RELATIONSHIP
     * ========================================
     */

    /**
     * Relasi ke Order (Many to One)
     * Banyak OrderItem dimiliki oleh 1 Order
     * 
     * Cara pakai:
     * $orderItem->order; // Ambil data order
     * $orderItem->order->invoice_number; // Ambil nomor invoice
     */

    public function order(){
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke Product (Many to One)
     * Banyak OrderItem merujuk ke 1 Product
     * 
     * Cara pakai:
     * $orderItem->product; // Ambil data produk
     * $orderItem->product->name; // Ambil nama produk
     */

    public function product(){
        return $this->belongsTo(Product::class);
    }

    /**
     * ========================================
     * ACCESSOR & MUTATOR
     * ========================================
     */

    /**
     * Accessor: Format price dengan Rupiah
     * 
     * Cara pakai:
     * $orderItem->formatted_price; // Rp 50.000
     */
    
    public function getFormattedPriceAttribute(){
        return 'Rp.' . number_format($this->price, 0 , ',', '.');
    }

    public function getFormattedSubtotalAttribute(){
        return 'Rp.' . number_format($this->subtotal, 0 , ',', '.');
    }

    /**
     * Mutator: Otomatis hitung subtotal saat set quantity atau price
     * 
     * Catatan: Ini akan otomatis jalan saat create() atau update()
     */

    public static function booted(){

        // event sebelum create
        static::creating(function($orderItem){
            $orderItem->calculateSubtotal();
        });

        // event sebelum update
        static::updating(function($orderItem){
            $orderItem->calculateSubtotal();
        });
    }

    /**
     * ========================================
     * HELPER METHODS
     * ========================================
     */

    /**
     * Hitung subtotal (quantity * price)
     * 
     * @return void
     */

    public function calculateSubtotal(){
        $this->subtotal = $this->quantity * $this->price;
    }

    /**
     * Set data dari produk
     * Digunakan saat create order item dari produk
     * 
     * @param Product $product
     * @param int $quantity
     * @return void
     */

    public function setFromProduct(Product $product, $quantity){
        $this->product_id = $product->id;      
        $this->quantity = $quantity;      
        $this->price = $product->price;      
        $this->calculateSubtotal();      
    }
}
