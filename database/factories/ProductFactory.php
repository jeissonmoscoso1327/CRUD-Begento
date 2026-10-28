<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define los atributos por defecto para un producto de prueba.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 1, 5000),
            'currency_id' => Currency::factory(),
            'tax_cost' => fake()->randomFloat(2, 0, 1000),
            'manufacturing_cost' => fake()->randomFloat(2, 0, 3000),
        ];
    }
}
