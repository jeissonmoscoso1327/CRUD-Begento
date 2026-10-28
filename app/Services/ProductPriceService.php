<?php

namespace App\Services;

use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Collection;

class ProductPriceService
{
    private const RELATIONS = ['product.currency', 'currency'];

    /**
     * Obtiene todos los precios de producto con sus relaciones.
     */
    public function list(): Collection
    {
        return ProductPrice::query()
            ->with(self::RELATIONS)
            ->orderBy('id')
            ->get();
    }

    /**
     * Crea un precio de producto nuevo y carga sus relaciones.
     */
    public function create(array $data): ProductPrice
    {
        $productPrice = ProductPrice::query()->create($data);

        return $productPrice->load(self::RELATIONS);
    }

    /**
     * Carga y devuelve un precio de producto con sus relaciones.
     */
    public function show(ProductPrice $productPrice): ProductPrice
    {
        return $productPrice->load(self::RELATIONS);
    }

    /**
     * Actualiza un precio de producto y devuelve su estado más reciente.
     */
    public function update(ProductPrice $productPrice, array $data): ProductPrice
    {
        $productPrice->update($data);

        return $productPrice->refresh()->load(self::RELATIONS);
    }

    /**
     * Elimina un precio de producto existente.
     */
    public function delete(ProductPrice $productPrice): void
    {
        $productPrice->delete();
    }
}
