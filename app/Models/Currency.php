<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'symbol', 'exchange_rate'];

    protected $casts = [
        'exchange_rate' => 'decimal:6',
    ];

    /**
     * Obtiene los productos asociados a la divisa.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Obtiene los precios de producto asociados a la divisa.
     */
    public function productPrices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }
}
