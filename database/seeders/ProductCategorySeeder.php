<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::create([
            'name' => 'B2C',
            'description' => 'Business to Consumer',
        ]);
        ProductCategory::create([
            'name' => 'B2B',
            'description' => 'Business to Business',
        ]);
    }
}
