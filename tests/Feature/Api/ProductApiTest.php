<?php

namespace Tests\Feature\Api;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que el endpoint liste productos con sus relaciones.
     */
    public function test_it_lists_products_with_relations(): void
    {
        $product = Product::factory()->create();
        ProductPrice::factory()->create([
            'product_id' => $product->id,
            'currency_id' => Currency::factory()->create()->id,
        ]);

        $response = $this->getJson('/api/products');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.0.id', $product->id)
            ->assertJsonPath('data.0.currency.id', $product->currency_id)
            ->assertJsonPath('data.0.prices.0.product_id', $product->id);
    }

    /**
     * Verifica que el endpoint cree un producto correctamente.
     */
    public function test_it_creates_a_product(): void
    {
        $currency = Currency::factory()->create();

        $payload = [
            'name' => 'Laptop Pro',
            'description' => 'Equipo para trabajo intensivo.',
            'price' => 2500.50,
            'currency_id' => $currency->id,
            'tax_cost' => 300.20,
            'manufacturing_cost' => 1200.10,
        ];

        $response = $this->postJson('/api/products', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Producto creado correctamente.');

        $this->assertDatabaseHas('products', $payload);
    }

    /**
     * Verifica que el endpoint muestre un producto con sus relaciones.
     */
    public function test_it_shows_a_product_with_relations(): void
    {
        $product = Product::factory()->create();
        $priceCurrency = Currency::factory()->create();
        ProductPrice::factory()->create([
            'product_id' => $product->id,
            'currency_id' => $priceCurrency->id,
        ]);

        $response = $this->getJson("/api/products/{$product->id}");

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $product->id)
            ->assertJsonPath('data.currency.id', $product->currency_id)
            ->assertJsonPath('data.prices.0.currency.id', $priceCurrency->id);
    }

    /**
     * Verifica que el endpoint actualice un producto existente.
     */
    public function test_it_updates_a_product(): void
    {
        $product = Product::factory()->create();
        $currency = Currency::factory()->create();

        $payload = [
            'name' => 'Monitor 4K',
            'description' => 'Pantalla profesional.',
            'price' => 899.99,
            'currency_id' => $currency->id,
            'tax_cost' => 80.50,
            'manufacturing_cost' => 500.00,
        ];

        $response = $this->putJson("/api/products/{$product->id}", $payload);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Monitor 4K')
            ->assertJsonPath('data.currency.id', $currency->id);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            ...$payload,
        ]);
    }

    /**
     * Verifica que el endpoint elimine un producto existente.
     */
    public function test_it_deletes_a_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
