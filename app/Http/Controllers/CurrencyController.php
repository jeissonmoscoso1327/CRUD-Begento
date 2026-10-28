<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(){
        try {
            $currencies = Currency::all();
    
            return response()->json([
                'success' => true,
                'data' => $currencies
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al obtener las divisas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request){
        try{

            $currencyValidate = Currency::where('name', $request->input('name'))->first();
            if($currencyValidate){
                return response()->json([
                    'success' => false,
                    'message' => 'The currency already exists.',
                ], 422);
            }

            $currency = new Currency();
            $currency->name = $request->input('name');
            $currency->symbol = $request->input('symbol');
            $currency->exchange_rate = $request->input('exchange_rate');
            $currency->save();
            
            return response()->json([
                'success' => true,
                'data' => "Currency created successfully.",
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al crear la divisa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
