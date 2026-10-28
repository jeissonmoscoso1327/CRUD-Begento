<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateCurrencyRequest extends ApiRequest
{
    /**
     * Define las reglas de validación para actualizar una divisa.
     */
    public function rules(): array
    {
        $currencyId = $this->route('currency')?->id ?? $this->route('currency');

        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('currencies', 'name')->ignore($currencyId)],
            'symbol' => ['required', 'string', 'max:100', Rule::unique('currencies', 'symbol')->ignore($currencyId)],
            'exchange_rate' => ['required', 'numeric', 'min:0'],
        ];
    }
}
