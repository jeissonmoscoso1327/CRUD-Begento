<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Inyecta el servicio encargado de la lógica de productos.
     */
    public function __construct(private readonly ProductService $productService)
    {
    }

    /**
     * Devuelve el listado de productos con sus relaciones.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->successResponse(
                data: $this->productService->list()
            );
        } catch (\Throwable $e) {
            Log::error('Error al listar los productos.', ['exception' => $e]);

            return $this->failureResponse('No se pudieron obtener los productos.');
        }
    }

    /**
     * Crea un producto nuevo con datos validados.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $this->productService->create($request->validated());

            return $this->successResponse(
                message: 'Producto creado correctamente.',
                status: 201
            );
        } catch (\Throwable $e) {
            Log::error('Error al crear el producto.', ['exception' => $e]);

            return $this->failureResponse('No se pudo crear el producto.');
        }
    }

    /**
     * Muestra un producto específico con sus relaciones.
     */
    public function show(Product $product): JsonResponse
    {
        try {
            return $this->successResponse(
                data: $this->productService->show($product)
            );
        } catch (\Throwable $e) {
            Log::error('Error al mostrar el producto.', [
                'exception' => $e,
                'product_id' => $product->id,
            ]);

            return $this->failureResponse('No se pudo obtener el producto.');
        }
    }

    /**
     * Actualiza un producto existente con datos validados.
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        try {
            $product = $this->productService->update($product, $request->validated());

            return $this->successResponse(
                data: $product,
                message: 'Producto actualizado correctamente.'
            );
        } catch (\Throwable $e) {
            Log::error('Error al actualizar el producto.', [
                'exception' => $e,
                'product_id' => $product->id,
            ]);

            return $this->failureResponse('No se pudo actualizar el producto.');
        }
    }

    /**
     * Elimina un producto existente.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $this->productService->delete($product);

            return $this->successResponse(
                message: 'Producto eliminado correctamente.'
            );
        } catch (\Throwable $e) {
            Log::error('Error al eliminar el producto.', [
                'exception' => $e,
                'product_id' => $product->id,
            ]);

            return $this->failureResponse('No se pudo eliminar el producto.');
        }
    }
}
