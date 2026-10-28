<?php

namespace Tests\Feature\Api;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que el endpoint liste las divisas registradas.
     */
    public function test_it_lists_currencies(): void
    {
        Currency::factory()->count(3)->create();

        $response = $this->getJson('/api/currencies');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(3, 'data');
    }

    /**
     * Verifica que el endpoint cree una divisa correctamente.
     */
    public function test_it_creates_a_currency(): void
    {
        $payload = [
            'name' => 'USD',
            'symbol' => '$',
            'exchange_rate' => 1.00,
        ];

        $response = $this->postJson('/api/currencies', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Divisa creada correctamente.');

        $this->assertDatabaseHas('currencies', $payload);
    }

    /**
     * Verifica que el endpoint muestre una divisa específica.
     */
    public function test_it_shows_a_currency(): void
    {
        $currency = Currency::factory()->create();

        $response = $this->getJson("/api/currencies/{$currency->id}");

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $currency->id);
    }

    /**
     * Verifica que el endpoint actualice una divisa existente.
     */
    public function test_it_updates_a_currency(): void
    {
        $currency = Currency::factory()->create();

        $payload = [
            'name' => 'EUR',
            'symbol' => 'EUR',
            'exchange_rate' => 0.92,
        ];

        $response = $this->putJson("/api/currencies/{$currency->id}", $payload);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'EUR');

        $this->assertDatabaseHas('currencies', [
            'id' => $currency->id,
            ...$payload,
        ]);
    }

    /**
     * Verifica que el endpoint elimine una divisa existente.
     */
    public function test_it_deletes_a_currency(): void
    {
        $currency = Currency::factory()->create();

        $response = $this->deleteJson("/api/currencies/{$currency->id}");

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('currencies', [
            'id' => $currency->id,
        ]);
    }
}
