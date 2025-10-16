<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Region;

class PriceController extends Controller{

    public function price(Request $request){
        $Setting = Setting::first();
        return response()->json([
            'success' => true,
            'message' => 'Narxlar.',
            'data' => $Setting
        ], 201);
    }

    public function price_create(Request $request){
        $request->validate([
            'water_price' => 'required|numeric|min:0',
            'idish_price' => 'required|numeric|min:0',
            'currer_price' => 'required|numeric|min:0',
            'sclad_price' => 'required|numeric|min:0',
            'operator_price' => 'required|numeric|min:0',
        ]);
        $Setting = Setting::first();
        $Setting->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Narxlar yangilandi.',
        ], 201);
    }
}
