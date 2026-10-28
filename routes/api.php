<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPriceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class);
Route::apiResource('product-prices', ProductPriceController::class);
Route::get('currencies', [CurrencyController::class, 'index']);
Route::post('currencies/create', [CurrencyController::class, 'store']);
