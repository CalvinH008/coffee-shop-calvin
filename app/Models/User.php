<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'address',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean'
        ];
    }

    /**
     * ========================================
     * RELATIONSHIP
     * ========================================
     */

    /**
     * Relasi ke Order (One to Many)
     * 1 User bisa punya banyak Order
     * 
     * Cara pakai:
     * $user->orders; // Ambil semua order user
     * $user->orders()->count(); // Hitung jumlah order
     */

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function verifiedPayments(){
        return $this->hasMany(Payment::class, 'verified_by');
    }

    /**
     * ========================================
     * SCOPE (Query Helper)
     * ========================================
     */

    /**
     * Scope: Ambil user dengan role admin
     * 
     * Cara pakai:
     * User::admin()->get();
     */

    public function scopeAdmin($query){
        return $query->where('role', 'admin');
    }

    /**
     * Scope: Ambil user dengan role customer
     * 
     * Cara pakai:
     * User::customer()->get();
     */

    public function scopeUser($query){
        return $query->where('role', 'user');
    }

    /**
     * Scope: Ambil user yang aktif
     * 
     * Cara pakai:
     * User::active()->get();
     */

    public function scopeActive($query){
        return $query->where('is_active', true);
    }

    /**
     * ========================================
     * HELPER METHODS
     * ========================================
     */

    /**
     * Cek apakah user adalah admin
     * 
     * @return bool
     */

    public function isAdmin(){
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah customer
     * 
     * @return bool
     */

    public function isUser(){
        return $this->role === 'user';
    }

    /**
     * Toggle status aktif/nonaktif
     * 
     * @return bool
     */

    public function toggleActive(){
        $this->is_active = !$this->is_active;
        return $this->save();
    }

    /**
     * Hitung total pembelian user
     * 
     * @return float
     */

    public function totalSpent(){
        return $this->orders()
                    ->where('status', 'completed')
                    ->sum('total');
    }

    /**
     * Hitung jumlah order yang sudah selesai
     * 
     * @return int
     */

    public function completedOrdersCount(){
        return $this->orders()
                    ->where('status', 'completed')
                    ->count();
    }
}
