<?php

namespace Tests\Feature\Api;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPriceApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que el endpoint liste precios de producto con relaciones.
     */
    public function test_it_lists_product_prices_with_relations(): void
    {
        $productPrice = ProductPrice::factory()->create();

        $response = $this->getJson('/api/product-prices');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.0.id', $productPrice->id)
            ->assertJsonPath('data.0.product.id', $productPrice->product_id)
            ->assertJsonPath('data.0.currency.id', $productPrice->currency_id);
    }

    /**
     * Verifica que el endpoint cree un precio de producto correctamente.
     */
    public function test_it_creates_a_product_price(): void
    {
        $product = Product::factory()->create();
        $currency = Currency::factory()->create();

        $payload = [
            'product_id' => $product->id,
            'currency_id' => $currency->id,
            'price' => 149.99,
        ];

        $response = $this->postJson('/api/product-prices', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Precio de producto creado correctamente.');

        $this->assertDatabaseHas('product_prices', $payload);
    }

    /**
     * Verifica que el endpoint muestre un precio de producto con relaciones.
     */
    public function test_it_shows_a_product_price_with_relations(): void
    {
        $productPrice = ProductPrice::factory()->create();

        $response = $this->getJson("/api/product-prices/{$productPrice->id}");

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $productPrice->id)
            ->assertJsonPath('data.product.id', $productPrice->product_id)
            ->assertJsonPath('data.currency.id', $productPrice->currency_id);
    }

    /**
     * Verifica que el endpoint actualice un precio de producto existente.
     */
    public function test_it_updates_a_product_price(): void
    {
        $productPrice = ProductPrice::factory()->create();
        $product = Product::factory()->create();
        $currency = Currency::factory()->create();

        $payload = [
            'product_id' => $product->id,
            'currency_id' => $currency->id,
            'price' => 199.95,
        ];

        $response = $this->putJson("/api/product-prices/{$productPrice->id}", $payload);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.product.id', $product->id)
            ->assertJsonPath('data.currency.id', $currency->id);

        $this->assertDatabaseHas('product_prices', [
            'id' => $productPrice->id,
            ...$payload,
        ]);
    }

    /**
     * Verifica que el endpoint elimine un precio de producto existente.
     */
    public function test_it_deletes_a_product_price(): void
    {
        $productPrice = ProductPrice::factory()->create();

        $response = $this->deleteJson("/api/product-prices/{$productPrice->id}");

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('product_prices', [
            'id' => $productPrice->id,
        ]);
    }
}
