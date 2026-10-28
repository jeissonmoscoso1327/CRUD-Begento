<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class StoreProductPriceRequest extends ApiRequest
{
    /**
     * Define las reglas de validación para crear un precio de producto.
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'currency_id' => [
                'required',
                'exists:currencies,id',
                Rule::unique('product_prices')->where(
                    fn ($query) => $query->where('product_id', $this->input('product_id'))
                ),
            ],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
