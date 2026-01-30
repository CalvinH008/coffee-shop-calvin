<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kopi Arabica',
                'description' => 'Kopi arabica dengan rasa smooth dan aroma khas',
                'is_active' => true,
            ],
            [
                'name' => 'Kopi Robusta',
                'description' => 'Kopi robusta dengan rasa bold dan kafein tinggi',
                'is_active' => true,
            ],
            [
                'name' => 'Kopi Blend',
                'description' => 'Campuran arabica dan robusta untuk rasa seimbang',
                'is_active' => true,
            ],
            [
                'name' => 'Non Coffee',
                'description' => 'Minuman non kopi seperti teh, chocolate, dan lainnya',
                'is_active' => true,
            ],
            [
                'name' => 'Snack',
                'description' => 'Makanan pendamping kopi',
                'is_active' => true,
            ],
            [
                'name' => 'Dessert',
                'description' => 'Makanan penutup manis',
                'is_active' => true,
            ],
            [
                'name' => 'Minuman Dingin',
                'description' => 'Minuman segar dan dingin',
                'is_active' => true,
            ],
        ];

        foreach($categories as $category){
            Category::create($category);
        }
    }
}
