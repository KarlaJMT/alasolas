<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Obtener todas las categorías existentes
        $categories = Category::all();

        // Crear productos para cada categoría
        $categories->each(function ($category) {
            // 5-10 productos por categoría
            Product::factory()
                ->count(rand(5, 10))
                ->inStock()
                ->create([
                    'category_id' => $category->id
                ]);
        });

        // Algunos productos premium
        Product::factory()
            ->count(5)
            ->expensive()
            ->inStock()
            ->create();
    }
}
