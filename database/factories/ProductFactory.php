<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition()
    {
        $name = $this->faker->words(3, true); // Genera 3 palabras
        
        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(3), // 3 párrafos
            'price' => $this->faker->randomFloat(2, 10, 1000), // Entre 10.00 y 1000.00
            'stock' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(85), // 85% activos
            'category_id' => Category::factory(), // Crea una categoría automáticamente
        ];
    }

    // Estado para productos en stock
    public function inStock()
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => $this->faker->numberBetween(10, 100),
            ];
        });
    }

    // Estado para productos caros
    public function expensive()
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => $this->faker->randomFloat(2, 500, 2000),
            ];
        });
    }
}
