<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateProductPriceRequest extends ApiRequest
{
    /**
     * Define las reglas de validación para actualizar un precio de producto.
     */
    public function rules(): array
    {
        $productPriceId = $this->route('product_price')?->id ?? $this->route('product_price');

        return [
            'product_id' => ['required', 'exists:products,id'],
            'currency_id' => [
                'required',
                'exists:currencies,id',
                Rule::unique('product_prices')->where(
                    fn ($query) => $query->where('product_id', $this->input('product_id'))
                )->ignore($productPriceId),
            ],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
