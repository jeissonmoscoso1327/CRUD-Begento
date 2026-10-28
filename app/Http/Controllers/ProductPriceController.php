<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductPriceRequest;
use App\Http\Requests\UpdateProductPriceRequest;
use App\Models\ProductPrice;
use App\Services\ProductPriceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProductPriceController extends Controller
{
    /**
     * Inyecta el servicio encargado de la lógica de precios por producto.
     */
    public function __construct(private readonly ProductPriceService $productPriceService)
    {
    }

    /**
     * Devuelve el listado de precios de producto con sus relaciones.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->successResponse(
                data: $this->productPriceService->list()
            );
        } catch (\Throwable $e) {
            Log::error('Error al listar los precios de producto.', ['exception' => $e]);

            return $this->failureResponse('No se pudieron obtener los precios de producto.');
        }
    }

    /**
     * Crea un precio de producto nuevo con datos validados.
     */
    public function store(StoreProductPriceRequest $request): JsonResponse
    {
        try {
            $this->productPriceService->create($request->validated());

            return $this->successResponse(
                message: 'Precio de producto creado correctamente.',
                status: 201
            );
        } catch (\Throwable $e) {
            Log::error('Error al crear el precio de producto.', ['exception' => $e]);

            return $this->failureResponse('No se pudo crear el precio de producto.');
        }
    }

    /**
     * Muestra un precio de producto específico con sus relaciones.
     */
    public function show(ProductPrice $productPrice): JsonResponse
    {
        try {
            return $this->successResponse(
                data: $this->productPriceService->show($productPrice)
            );
        } catch (\Throwable $e) {
            Log::error('Error al mostrar el precio de producto.', [
                'exception' => $e,
                'product_price_id' => $productPrice->id,
            ]);

            return $this->failureResponse('No se pudo obtener el precio de producto.');
        }
    }

    /**
     * Actualiza un precio de producto existente con datos validados.
     */
    public function update(UpdateProductPriceRequest $request, ProductPrice $productPrice): JsonResponse
    {
        try {
            $productPrice = $this->productPriceService->update($productPrice, $request->validated());

            return $this->successResponse(
                data: $productPrice,
                message: 'Precio de producto actualizado correctamente.'
            );
        } catch (\Throwable $e) {
            Log::error('Error al actualizar el precio de producto.', [
                'exception' => $e,
                'product_price_id' => $productPrice->id,
            ]);

            return $this->failureResponse('No se pudo actualizar el precio de producto.');
        }
    }

    /**
     * Elimina un precio de producto existente.
     */
    public function destroy(ProductPrice $productPrice): JsonResponse
    {
        try {
            $this->productPriceService->delete($productPrice);

            return $this->successResponse(
                message: 'Precio de producto eliminado correctamente.'
            );
        } catch (\Throwable $e) {
            Log::error('Error al eliminar el precio de producto.', [
                'exception' => $e,
                'product_price_id' => $productPrice->id,
            ]);

            return $this->failureResponse('No se pudo eliminar el precio de producto.');
        }
    }
}
