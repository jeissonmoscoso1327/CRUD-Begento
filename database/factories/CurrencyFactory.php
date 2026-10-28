<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    /**
     * Define los atributos por defecto para una divisa de prueba.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->currencyCode(),
            'symbol' => fake()->unique()->currencyCode(),
            'exchange_rate' => fake()->randomFloat(2, 0.01, 9999.99),
        ];
    }
}
