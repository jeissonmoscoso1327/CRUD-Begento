<?php

namespace App\Http\Requests;

class UpdateProductRequest extends ApiRequest
{
    /**
     * Define las reglas de validación para actualizar un producto.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency_id' => ['required', 'exists:currencies,id'],
            'tax_cost' => ['required', 'numeric', 'min:0'],
            'manufacturing_cost' => ['required', 'numeric', 'min:0'],
        ];
    }
}
