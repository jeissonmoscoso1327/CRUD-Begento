<?php

namespace App\Http\Controllers;

use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductPriceController extends Controller
{
    public function index(){
        try {
            $products = ProductPrice::all();
    
            return response()->json([
                'success' => true,
                'data' => $products
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al obtener los productos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request){
        try{
            $validated = $request->validate([
                'product_id' => ['required'],
                'currency_id' => ['required'],
                'price' => ['required', 'numeric', 'min:0'],
            ]);

            $productPrice = ProductPrice::create($validated);
            $productPrice->load(['product', 'currency']);

            return response()->json([
                'success' => true,
                'message' => 'Precio del producto creado correctamente.',
            ], 201);
        }
        catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Los datos enviados no son válidos.',
                'errors' => $e->errors(),
            ], 422);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al crear el precio del producto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
