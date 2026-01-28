<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_id' => 1,
                'name' => 'Kopi Aceh Gayo',
                'slug' => 'kopi-aceh-gayo',
                'description' => 'Kopi arabika khas Aceh dengan rasa strong',
                'price' => 25000,
                'stock' => 50,
                'image' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'Kopi Toraja',
                'slug' => 'kopi-toraja',
                'description' => 'Kopi Toraja dengan aroma earthy',
                'price' => 27000,
                'stock' => 40,
                'image' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'name' => 'Croissant',
                'slug' => 'croissant',
                'description' => 'Snack pendamping kopi',
                'price' => 18000,
                'stock' => 30,
                'image' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
