<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * ========================================
 * MODEL: Product
 * Fungsi: Mengelola data produk kopi
 * Tabel: products
 * ========================================
 */

class Product extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'products';

    /**
     * Field yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'is_active'
    ];

    /**
     * Field yang akan di-cast ke tipe data tertentu
     */
    protected $casts = [
        'price' => 'decimal',
        'stock' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * ========================================
     * RELATIONSHIP
     * ========================================
     */

    /**
     * Relasi ke Category (Many to One)
     * Banyak Product dimiliki oleh 1 Category
     * 
     * Cara pakai:
     * $product->category; // Ambil kategori produk ini
     * $product->category->name; // Ambil nama kategori
     */

    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke OrderItem (One to Many)
     * 1 Product bisa ada di banyak OrderItem
     * 
     * Cara pakai:
     * $product->orderItems; // Ambil semua order yang berisi produk ini
     */

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    /**
     * ========================================
     * ACCESSOR & MUTATOR
     * ========================================
     */

    /**
     * Mutator: Otomatis generate slug dari name
     */

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Accessor: Format harga dengan Rupiah
     * 
     * Cara pakai:
     * $product->formatted_price; // Rp 50.000
     */

    public function getFormattedPriceAttribute(){
        return 'Rp. ' .  number_format($this->price, 0, ',', '.');
    }

    /**
     * Accessor: Get full image URL
     * 
     * Cara pakai:
     * $product->image_url; // http://localhost/storage/products/image.jpg
     */

    public function getImageUrlAttribute(){
        if($this->image){
            return Storage::url($this->image);
        }

        // return jika tidak ada image
        return asset('images/no-image.png');
    }

    /**
     * ========================================
     * SCOPE (Query Helper)
     * ========================================
     */

    /**
     * Scope: Ambil produk yang aktif/publish saja
     * 
     * Cara pakai:
     * Product::active()->get();
     */

    public function scopeActive($query){
        return $query->where('is_active', true);
    }

    /**
     * Scope: Ambil produk yang stock-nya masih ada
     * 
     * Cara pakai:
     * Product::inStock()->get();
     */

    public function scopeInStock($query){
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope: Ambil produk dengan stock rendah (< 10)
     * 
     * Cara pakai:
     * Product::lowStock()->get();
     */

    public function scopeLowStock($query){
        return $query->where('stock', '<', 10)->where('stock', '>' , 0);
    }

    /**
     * Scope: Ambil produk dengan kategori tertentu
     * 
     * Cara pakai:
     * Product::byCategory($categoryId)->get();
     */

    public function scopeByCategory($query, $categoryId){
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope: Search produk by name
     * 
     * Cara pakai:
     * Product::search('arabica')->get();
     */

    public function scopeSearch($query, $keyword){
        return $query->where('name', 'LIKE', "%{$keyword}%")->orWhere('description', 'LIKE', "%{$keyword}%");
    }

    /**
     * ========================================
     * HELPER METHODS
     * ========================================
     */

    /**
     * Cek apakah stock masih tersedia
     * 
     * @return bool
     */

    public function isInStock(){
        return $this->stock > 0;
    }

    /**
     * Cek apakah stock rendah (< 10)
     * 
     * @return bool
     */

    public function isLowStock(){
        return $this->stock < 10 && $this->stock > 0;
    }

    /**
     * Kurangi stock produk
     * 
     * @param int $quantity
     * @return bool
     */

    public function decreaseStock($quantity){
        if($this->stock<$quantity){
            return false;
        }

        $this->stock -=$quantity;
        return $this->save();
    }

    /**
     * Tambah stock produk
     * 
     * @param int $quantity
     * @return bool
     */

    public function increaseStock($quantity){
        $this->stock +=$quantity;
        return $this->save();
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
     * Hapus gambar produk dari storage
     * 
     * @return bool
     */

    public function deleteImage(){
        if($this->image && Storage::exists($this->image)){
            return Storage::delete($this->image);
        }

        return false;
    }
}
