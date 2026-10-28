<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrencyService
{
    /**
     * Obtiene todas las divisas ordenadas por identificador.
     */
    public function list(): Collection
    {
        return Currency::query()
            ->orderBy('id')
            ->get();
    }

    /**
     * Crea una divisa nueva.
     */
    public function create(array $data): Currency
    {
        return Currency::query()->create($data);
    }

    /**
     * Actualiza una divisa existente.
     */
    public function update(Currency $currency, array $data): Currency
    {
        $currency->update($data);

        return $currency->refresh();
    }

    /**
     * Elimina una divisa existente.
     */
    public function delete(Currency $currency): void
    {
        $currency->delete();
    }
}
