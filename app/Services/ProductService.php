<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    private const RELATIONS = ['currency', 'prices.currency'];

    /**
     * Obtiene todos los productos con sus relaciones principales.
     */
    public function list(): Collection
    {
        return Product::query()
            ->with(self::RELATIONS)
            ->orderBy('id')
            ->get();
    }

    /**
     * Crea un producto nuevo y carga sus relaciones.
     */
    public function create(array $data): Product
    {
        $product = Product::query()->create($data);

        return $product->load(self::RELATIONS);
    }

    /**
     * Carga y devuelve un producto con sus relaciones.
     */
    public function show(Product $product): Product
    {
        return $product->load(self::RELATIONS);
    }

    /**
     * Actualiza un producto y devuelve su estado más reciente.
     */
    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->refresh()->load(self::RELATIONS);
    }

    /**
     * Elimina un producto existente.
     */
    public function delete(Product $product): void
    {
        $product->delete();
    }
}
