<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * ========================================
 * MODEL: Order
 * Fungsi: Mengelola data pesanan/order
 * Tabel: orders
 * ========================================
 */

class Order extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */

    protected $table = 'orders';

    /**
     * Field yang boleh diisi (mass assignment)
     */

    protected $fillable = [
        'user_id',
        'invoice_number',
        'total',
        'status',
        'payment_method',
        'shipping_address',
        'notes',
    ];

    /**
     * Field yang akan di-cast ke tipe data tertentu
     */

    protected $casts = [
        'total' => 'decimal:2'
    ];

    /**
     * ========================================
     * RELATIONSHIP
     * ========================================
     */

    /**
     * Relasi ke User (Many to One)
     * Banyak Order dimiliki oleh 1 User
     * 
     * Cara pakai:
     * $order->user; // Ambil data user yang order
     * $order->user->name; // Ambil nama user
     */

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke OrderItem (One to Many)
     * 1 Order punya banyak OrderItem (detail produk yang dibeli)
     * 
     * Cara pakai:
     * $order->items; // Ambil semua item dalam order ini
     * $order->items->count(); // Hitung jumlah item
     */

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke Payment (One to Many)
     * 1 Order bisa punya banyak Payment
     * 
     * Cara pakai:
     * $order->payments; // Ambil semua payment untuk order ini
     * $order->payments()->sum('amount'); // Total yang sudah dibayar
     */

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    /**
     * Ambil payment yang sudah verified
     */

    public function verifiedPayments(){
        return $this->payments()->where('status', 'verified');
    }

    /**
     * Hitung total yang sudah dibayar
     * 
     * @return float
     */

    public function totalPaid(){
        return $this->payments()
                    ->where('status', 'verified')
                    ->sum('amount');
    }

    /**
     * Hitung sisa yang belum dibayar
     * 
     * @return float
     */

    public function remainingPayment(){
        return $this->total - $this->totalPaid();
    }

    /**
     * Cek apakah order sudah lunas
     * 
     * @return bool
     */
    
    public function isFullyPaid(){
        return $this->totalPaid() >= $this->total;
    }

    /**
     * ========================================
     * ACCESSOR & MUTATOR
     * ========================================
     */

    /**
     * Accessor: Format total dengan Rupiah
     * 
     * Cara pakai:
     * $order->formatted_total; // Rp 150.000
     */

    public function getFormattedTotalAttribute(){
        return 'Rp. ' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Accessor: Status dalam Bahasa Indonesia
     * 
     * Cara pakai:
     * $order->status_label; // Menunggu Pembayaran
     */

    public function getLabelAttribute(){
        $statusLabels = [
            'pending' => 'Menunggu pembayaran',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'canceled' => 'Dibatalkan'
        ];

        return $statusLabels[$this->status] ?? 'Unknown';
    }

    /**
     * Accessor: Badge color untuk status
     * 
     * Cara pakai:
     * $order->status_color; // 'warning' atau 'success', dll
     */

    public function getColorLabelAttribute(){
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'completed' => 'success',
            'canceled' => 'danger'
        ];
        
        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Accessor: Payment method label
     * 
     * Cara pakai:
     * $order->payment_label; // Transfer Bank
     */

    public function getPaymentLabelAttribute(){
        $labels = [
            'cash' => 'Tunai',
            'transfer' => 'Transfer Bank',
            'cod' => 'Bayar Di Tempat'
        ];

        return $labels[$this->payment_method] ?? 'Unknown';
    }

    /**
     * ========================================
     * SCOPE (Query Helper)
     * ========================================
     */

    /**
     * Scope: Ambil order dengan status tertentu
     * 
     * Cara pakai:
     * Order::status('pending')->get();
     */

    public function scopeStatus($query, $status){
        return $query->where('status', $status);
    }

    /**
     * Scope: Ambil order pending
     */

    public function scopePending($query){
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Ambil order completed
     */
    
    public function scopeCompleted($query){
        return $query->where('status', 'completed');
    }

    /**
     * Scope: Ambil order hari ini
     * 
     * Cara pakai:
     * Order::today()->get();
     */

    public function scopeToday($query){
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Scope: Ambil order bulan ini
     * 
     * Cara pakai:
     * Order::thisMonth()->get();
     */

    public function scopeThisMonth($query){
        return $query->whereYear('created_at', Carbon::now()->year)
                     ->whereMonth('created_at', Carbon::now()->month);
    }

    /**
     * ========================================
     * HELPER METHODS
     * ========================================
     */

    /**
     * Generate invoice number otomatis
     * Format: INV/YYYY/MM/XXXX
     * Contoh: INV/2024/01/0001
     * 
     * @return string
     */

    public static function generateInvoiceNumber(){
        $year = Carbon::now()->year;
        $month = Carbon::now()->format('m');

        // ambil nomor invoice terakhir bulan ini
        $lastOrder = self::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->orderBy('id', 'desc')
                    ->first();
                    
        // jika tidak ada order di bulan ini, mulai dari 1
        $nextNumber = $lastOrder ? (intval(substr($lastOrder->invoice_number, -4)) + 1) : 1;

        // format nomor dengan 4 digit
        return sprintf('INV/%s/%s/%04d', $year, $month, $nextNumber);
    }

    /**
     * Update status order
     * 
     * @param string $status
     * @return bool
     */

    public function updateStatus($status){
        $this->status = $status;

        // jika status completed, set completed_at
        if($status === 'completed'){
            $this->completed_at = Carbon::now();
        }

        return $this->save();
    }

    /**
     * Hitung total dari semua items
     * 
     * @return float
     */

    public function calculateTotal(){
        return $this->items()->sum('subtotal');
    }

    /**
     * Cek apakah order bisa dibatalkan
     * (Hanya pending dan processing yang bisa dibatalkan)
     * 
     * @return bool
     */

    public function canBeCanceled(){
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * Batalkan order
     * 
     * @return bool
     */

    public function cancel(){
        if(!$this->canBeCanceled()){
            return false;
        }

        // kembalikan stock product
        foreach($this->items as $item){
            $item->product->increaseStock($item->quantity);
        }

        return $this->updateStatus('canceled');
    }
}
