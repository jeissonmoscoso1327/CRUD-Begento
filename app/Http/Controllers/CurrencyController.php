<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CurrencyController extends Controller
{
    /**
     * Inyecta el servicio encargado de la lógica de divisas.
     */
    public function __construct(private readonly CurrencyService $currencyService)
    {
    }

    /**
     * Devuelve el listado completo de divisas.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->successResponse(
                data: $this->currencyService->list()
            );
        } catch (\Throwable $e) {
            Log::error('Error al listar las divisas.', ['exception' => $e]);

            return $this->failureResponse('No se pudieron obtener las divisas.');
        }
    }

    /**
     * Crea una nueva divisa a partir de datos validados.
     */
    public function store(StoreCurrencyRequest $request): JsonResponse
    {
        try {
            $this->currencyService->create($request->validated());

            return $this->successResponse(
                message: 'Divisa creada correctamente.',
                status: 201
            );
        } catch (\Throwable $e) {
            Log::error('Error al crear la divisa.', ['exception' => $e]);

            return $this->failureResponse('No se pudo crear la divisa.');
        }
    }

    /**
     * Muestra una divisa específica.
     */
    public function show(Currency $currency): JsonResponse
    {
        try {
            return $this->successResponse(
                data: $currency
            );
        } catch (\Throwable $e) {
            Log::error('Error al mostrar la divisa.', [
                'exception' => $e,
                'currency_id' => $currency->id,
            ]);

            return $this->failureResponse('No se pudo obtener la divisa.');
        }
    }

    /**
     * Actualiza una divisa existente con datos validados.
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency): JsonResponse
    {
        try {
            $currency = $this->currencyService->update($currency, $request->validated());

            return $this->successResponse(
                data: $currency,
                message: 'Divisa actualizada correctamente.'
            );
        } catch (\Throwable $e) {
            Log::error('Error al actualizar la divisa.', [
                'exception' => $e,
                'currency_id' => $currency->id,
            ]);

            return $this->failureResponse('No se pudo actualizar la divisa.');
        }
    }

    /**
     * Elimina una divisa existente.
     */
    public function destroy(Currency $currency): JsonResponse
    {
        try {
            $this->currencyService->delete($currency);

            return $this->successResponse(
                message: 'Divisa eliminada correctamente.'
            );
        } catch (\Throwable $e) {
            Log::error('Error al eliminar la divisa.', [
                'exception' => $e,
                'currency_id' => $currency->id,
            ]);

            return $this->failureResponse('No se pudo eliminar la divisa.');
        }
    }
}
