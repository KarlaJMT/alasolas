<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition()
    {
        $name = $this->faker->words(2, true); // Genera 2 palabras
        
        return [
            'name' => ucwords($name), // Primera letra en mayúscula
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(10), // Oración de 10 palabras
            'is_active' => $this->faker->boolean(80), // 80% true, 20% false
        ];
    }

    // Estado personalizado para categorías activas
    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => true,
            ];
        });
    }
}
