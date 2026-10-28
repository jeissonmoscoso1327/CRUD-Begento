<?php

namespace App\Http\Requests;

class StoreCurrencyRequest extends ApiRequest
{
    /**
     * Define las reglas de validación para crear una divisa.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:currencies,name'],
            'symbol' => ['required', 'string', 'max:100', 'unique:currencies,symbol'],
            'exchange_rate' => ['required', 'numeric', 'min:0'],
        ];
    }
}
