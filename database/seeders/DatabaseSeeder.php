<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Product Category
        ProductCategory::create(['name' => 'Luxury']);
        ProductCategory::create(['name' => 'Sport']);
        ProductCategory::create(['name' => 'Hiking']);
        ProductCategory::create(['name' => 'Basketball']);
        ProductCategory::create(['name' => 'Tennis']);

        // Product
        Product::create([
            'name' => 'Nike Air Jourdan',
            'price' => 60000000,    
            'description' => 'Lorem ipsum dolor sit amet.',
            'tags' => 'waterproof',
            'category_id' => 1
        ]);
    }
}
