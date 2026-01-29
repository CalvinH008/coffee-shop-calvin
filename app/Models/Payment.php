<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

/**
 * ========================================
 * MODEL: Payment
 * Fungsi: Mengelola data pembayaran order
 * Tabel: payments
 * ========================================
 */
class Payment extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'payments';

    /**
     * Field yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'order_id',          // ID order (foreign key)
        'amount',            // Jumlah yang dibayar
        'payment_method',    // Metode pembayaran
        'status',            // Status pembayaran
        'proof_image',       // Path bukti transfer
        'bank_name',         // Nama bank
        'account_name',      // Nama rekening pengirim
        'account_number',    // Nomor rekening pengirim
        'reference_number',  // Nomor referensi
        'notes',             // Catatan customer
        'admin_notes',       // Catatan admin
        'verified_by',       // ID admin yang verifikasi
        'verified_at',       // Waktu verifikasi
    ];

    /**
     * Field yang akan di-cast ke tipe data tertentu
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    /**
     * ========================================
     * RELATIONSHIP
     * ========================================
     */

    /**
     * Relasi ke Order (Many to One)
     * Banyak Payment dimiliki oleh 1 Order
     * 
     * Cara pakai:
     * $payment->order; // Ambil data order
     * $payment->order->invoice_number;
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke User (verified_by)
     * Payment diverifikasi oleh 1 Admin (User)
     * 
     * Cara pakai:
     * $payment->verifiedBy; // Ambil admin yang verifikasi
     * $payment->verifiedBy->name;
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * ========================================
     * ACCESSOR & MUTATOR
     * ========================================
     */

    /**
     * Accessor: Format amount dengan Rupiah
     * 
     * Cara pakai:
     * $payment->formatted_amount; // Rp 150.000
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Accessor: Get full proof image URL
     * 
     * Cara pakai:
     * $payment->proof_url; // http://localhost/storage/payments/bukti.jpg
     */
    public function getProofUrlAttribute()
    {
        if ($this->proof_image) {
            return Storage::url($this->proof_image);
        }
        
        return null;
    }

    /**
     * Accessor: Status dalam Bahasa Indonesia
     * 
     * Cara pakai:
     * $payment->status_label; // Menunggu Verifikasi
     */
    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
        ];

        return $statusLabels[$this->status] ?? 'Unknown';
    }

    /**
     * Accessor: Badge color untuk status
     * 
     * Cara pakai:
     * $payment->status_color; // 'warning', 'success', 'danger'
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'verified' => 'success',
            'rejected' => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Accessor: Payment method label
     * 
     * Cara pakai:
     * $payment->payment_label; // Transfer Bank
     */
    public function getPaymentLabelAttribute()
    {
        $labels = [
            'bank_transfer' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet (GoPay, OVO, dll)',
            'cod' => 'Bayar di Tempat (COD)',
            'cash' => 'Tunai',
        ];

        return $labels[$this->payment_method] ?? 'Unknown';
    }

    /**
     * ========================================
     * SCOPE (Query Helper)
     * ========================================
     */

    /**
     * Scope: Ambil payment dengan status tertentu
     * 
     * Cara pakai:
     * Payment::status('pending')->get();
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Ambil payment pending (menunggu verifikasi)
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Ambil payment yang sudah verified
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope: Ambil payment yang rejected
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope: Ambil payment hari ini
     * 
     * Cara pakai:
     * Payment::today()->get();
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Scope: Ambil payment bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereYear('created_at', Carbon::now()->year)
                     ->whereMonth('created_at', Carbon::now()->month);
    }

    /**
     * ========================================
     * HELPER METHODS
     * ========================================
     */

    /**
     * Verifikasi pembayaran (approve)
     * 
     * @param int $adminId - ID admin yang verifikasi
     * @return bool
     */
    public function verify($adminId)
    {
        $this->status = 'verified';
        $this->verified_by = $adminId;
        $this->verified_at = Carbon::now();
        
        // Update status order jadi 'processing'
        if ($this->order) {
            $this->order->updateStatus('processing');
        }
        
        return $this->save();
    }

    /**
     * Tolak pembayaran (reject)
     * 
     * @param int $adminId - ID admin yang tolak
     * @param string $reason - Alasan penolakan
     * @return bool
     */
    public function reject($adminId, $reason = null)
    {
        $this->status = 'rejected';
        $this->verified_by = $adminId;
        $this->verified_at = Carbon::now();
        
        if ($reason) {
            $this->admin_notes = $reason;
        }
        
        return $this->save();
    }

    /**
     * Cek apakah payment sudah diverifikasi
     * 
     * @return bool
     */
    public function isVerified()
    {
        return $this->status === 'verified';
    }

    /**
     * Cek apakah payment masih pending
     * 
     * @return bool
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Cek apakah payment ditolak
     * 
     * @return bool
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Hapus bukti pembayaran dari storage
     * 
     * @return bool
     */
    public function deleteProofImage()
    {
        if ($this->proof_image && Storage::exists($this->proof_image)) {
            return Storage::delete($this->proof_image);
        }
        
        return false;
    }

    /**
     * Get payment info untuk notifikasi
     * 
     * @return array
     */
    public function getPaymentInfo()
    {
        return [
            'invoice' => $this->order->invoice_number,
            'amount' => $this->formatted_amount,
            'method' => $this->payment_label,
            'status' => $this->status_label,
            'bank' => $this->bank_name,
            'account_name' => $this->account_name,
            'paid_at' => $this->created_at->format('d M Y H:i'),
        ];
    }
}