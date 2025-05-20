<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Gourmet Entrées','Petite Pleasures','Refined Refreshments','Harvest Elegance'] as $categoryName) {
            ProductCategory::firstOrCreate(['role_name'=>$categoryName]);
        }
    }
}
