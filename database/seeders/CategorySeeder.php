<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Coffee',
                'slug' => 'coffee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Non Coffee',
                'slug' => 'non-coffee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Snack',
                'slug' => 'snack',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
