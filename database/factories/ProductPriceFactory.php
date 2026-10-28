<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductPrice>
 */
class ProductPriceFactory extends Factory
{
    protected $model = ProductPrice::class;

    /**
     * Define los atributos por defecto para un precio de producto de prueba.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'currency_id' => Currency::factory(),
            'price' => fake()->randomFloat(2, 1, 5000),
        ];
    }
}
