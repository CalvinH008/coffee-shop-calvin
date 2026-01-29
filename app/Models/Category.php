<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * ========================================
 * MODEL: Category
 * Fungsi: Mengelola data kategori produk kopi
 * Tabel: categories
 * ========================================
 */

class Category extends Model
{
    use HasFactory;
    
    /**
     * nama table di database
     * secara default laravel akan gunakan 'categories'(bentuk plural dari nama model)
     */
    protected $table = 'categories';
   
    /**
    * field yang boleh diisi bisa pakai fillable atau guarded 
    */
    
    protected $fillable = [
        'name', // nama kategori
        'slug', // infomasi kategori
        'description', // deskripsi
        'is_active' // status aktif atau nonaktif
    ]; 

    /**
     * casts untuk mengubah suatu field menjadi type data 
     * mengubah tipe data dari database ke php  
     */
    protected $casts = ['is_active' => 'boolean'];

    /**
     * ========================================
     * RELATIONSHIP
     * ========================================
     */

    /**
     * Relasi ke Product (One to Many)
     * 1 Category bisa punya banyak Product
     * 
     * Cara pakai:
     * $category->products; // Ambil semua produk dalam kategori ini
     * $category->products()->count(); // Hitung jumlah produk
     */

    public function products(){
        return $this->hasMany(Product::class);
    }

    /**
     * ========================================
     * ACCESSOR & MUTATOR
     * ========================================
     */

    /**
     * Mutator: Otomatis generate slug dari name
     * Akan jalan saat Category::create() atau $category->name = "..."
     * 
     * Contoh: name = "Kopi Arabica" → slug = "kopi-arabica"
     */

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * ========================================
     * SCOPE (Query Helper)
     * ========================================
     */

    /**
     * Scope: Ambil hanya kategori yang aktif
     * 
     * Cara pakai:
     * Category::active()->get(); // Ambil kategori aktif saja
     */

    public function scopeActive($query){
        return $query->where('is_active', true);
    }

    /**
     * Scope: Ambil kategori dengan jumlah produk
     * 
     * Cara pakai:
     * Category::withProductCount()->get();
     */

    public function scopeWithProductCount($query){
        return $query->withCount('products');
    }

    /**
     * ========================================
     * HELPER METHODS
     * ========================================
     */

    /**
     * Cek apakah kategori punya produk
     * 
     * @return bool
     */

    public function hasProducts(){
        return $this->products()->count() > 0;
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
}
