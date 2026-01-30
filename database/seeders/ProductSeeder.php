<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
       $products = [
            // Arabica
            ['category_id' => 1, 'name' => 'Kopi Aceh Gayo', 'description' => 'Kopi arabika khas Aceh dengan rasa fruity', 'price' => 35000, 'stock' => 50],
            ['category_id' => 1, 'name' => 'Kopi Toraja', 'description' => 'Kopi dari Sulawesi dengan aroma earthy', 'price' => 40000, 'stock' => 40],
            ['category_id' => 1, 'name' => 'Kopi Bali Kintamani', 'description' => 'Kopi dari Bali dengan citrus notes', 'price' => 38000, 'stock' => 35],
            ['category_id' => 1, 'name' => 'Kopi Java Preanger', 'description' => 'Kopi dari Jawa Barat dengan body medium', 'price' => 32000, 'stock' => 60],
            
            // Robusta
            ['category_id' => 2, 'name' => 'Kopi Lampung', 'description' => 'Robusta khas Lampung dengan rasa bold', 'price' => 28000, 'stock' => 70],
            ['category_id' => 2, 'name' => 'Kopi Bengkulu', 'description' => 'Robusta dengan kafein tinggi', 'price' => 26000, 'stock' => 55],
            
            // Blend
            ['category_id' => 3, 'name' => 'House Blend', 'description' => 'Campuran spesial arabica dan robusta', 'price' => 30000, 'stock' => 80],
            ['category_id' => 3, 'name' => 'Signature Blend', 'description' => 'Blend premium untuk rasa sempurna', 'price' => 45000, 'stock' => 45],
            
            // Non Coffee
            ['category_id' => 4, 'name' => 'Teh Tarik', 'description' => 'Teh susu khas Malaysia', 'price' => 15000, 'stock' => 100],
            ['category_id' => 4, 'name' => 'Hot Chocolate', 'description' => 'Coklat panas creamy', 'price' => 18000, 'stock' => 90],
            ['category_id' => 4, 'name' => 'Matcha Latte', 'description' => 'Green tea latte premium', 'price' => 25000, 'stock' => 60],
            
            // Snack
            ['category_id' => 5, 'name' => 'Croissant', 'description' => 'Pastry butter premium', 'price' => 22000, 'stock' => 40],
            ['category_id' => 5, 'name' => 'Donut', 'description' => 'Donut dengan berbagai topping', 'price' => 12000, 'stock' => 70],
            ['category_id' => 5, 'name' => 'Banana Bread', 'description' => 'Roti pisang homemade', 'price' => 18000, 'stock' => 35],
            
            // Dessert
            ['category_id' => 6, 'name' => 'Brownies', 'description' => 'Brownies coklat fudgy', 'price' => 20000, 'stock' => 50],
            ['category_id' => 6, 'name' => 'Tiramisu', 'description' => 'Dessert Italia klasik', 'price' => 35000, 'stock' => 25],
            ['category_id' => 6, 'name' => 'Cheesecake', 'description' => 'Cheesecake creamy', 'price' => 32000, 'stock' => 30],
            
            // Minuman Dingin
            ['category_id' => 7, 'name' => 'Es Kopi Susu', 'description' => 'Kopi susu dingin segar', 'price' => 18000, 'stock' => 120],
            ['category_id' => 7, 'name' => 'Ice Lemon Tea', 'description' => 'Teh lemon segar', 'price' => 12000, 'stock' => 150],
            ['category_id' => 7, 'name' => 'Smoothie Bowl', 'description' => 'Smoothie buah dengan topping', 'price' => 28000, 'stock' => 40],
        ];

        foreach($products as $product){
            Product::create(array_merge($product, ['is_active' => true]));
        }
    }
}
