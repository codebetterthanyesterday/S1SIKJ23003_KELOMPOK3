<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all category and store IDs
        // $categoryIds = \App\Models\ProductCategory::pluck('id_category')->toArray();
        // $storeIds = \App\Models\Store::pluck('id_store')->toArray();

        // If there are no categories or stores, do nothing
        // if (empty($categoryIds) || empty($storeIds)) {
        //     return;
        // }

        // Seed 32 products
        for ($i = 1; $i <= 32; $i++) {
            Product::create([
                'product_name' => 'Product ' . $i,
                'slug' => 'product-' . $i,
                'description' => 'Description for product ' . $i,
                'price' => rand(10000, 100000),
                'stock' => rand(10, 100),
                'id_category' => 1,
                'id_store' => 1,
            ]);
        }
    }
}
