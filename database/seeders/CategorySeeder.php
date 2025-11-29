<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fruits & Vegetables', 'slug' => 'fruits-vegetables', 'image' => 'admin/images/icon-vegetables-broccoli.png', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Breads & Bakery', 'slug' => 'breads-bakery', 'image' => 'admin/images/icon-bread-baguette.png', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Beverages', 'slug' => 'beverages', 'image' => 'admin/images/icon-soft-drinks-bottle.png', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'Meat & Poultry', 'slug' => 'meat-poultry', 'image' => 'admin/images/icon-animal-products-drumsticks.png', 'is_active' => true, 'sort_order' => 4],
            ['name' => 'Dairy Products', 'slug' => 'dairy-products', 'image' => 'admin/images/icon-bread-herb-flour.png', 'is_active' => true, 'sort_order' => 5],
        ];

        // Delete Wine & Spirits if exists
        Category::where('slug', 'wine-spirits')->delete();

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
