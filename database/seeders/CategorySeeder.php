<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Gourmet Entrées','Petite Pleasures','Refined Refreshments','Harvest Elegance'] as $categoryName) {
            ProductCategory::firstOrCreate(
            ['category_name' => $categoryName],
            ['slug' => Str::slug($categoryName)]
            );
        }
    }
}
