<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Region;

class SettingController extends Controller{

    public function region(){
        $region = Region::where('status','true')->with('user:id,name')->get();
        return view('setting.region',compact('region'));
    }
    public function region_create(Request $request){
        $request->validate([
            'name' => 'required|string',
        ]);
        Region::create([
            'name' => $request->name,
            'status' => true,
            'user_id' => auth()->user()->id,
        ]);
        return back()->with('success', 'Yangi hudud saqlandi.');
    }
    public function region_delete(Request $request){
        $Region = Region::find($request->id);
        $Region->status = 'delete';
        $Region->save();
        return redirect()->back()->with('success', 'Hudud o\'chirildi.');
    }

    public function price(){
        $Setting = Setting::first();
        return view('setting.price',compact('Setting'));
    }
    public function update_price(Request $request){
        $request->validate([
            'water_price' => 'required|numeric|min:0',
            'idish_price' => 'required|numeric|min:0',
            'currer_price' => 'required|numeric|min:0',
            'sclad_price' => 'required|numeric|min:0',
            'operator_price' => 'required|numeric|min:0',
        ]);
        $Setting = Setting::first();
        $Setting->update($request->all());
        return back()->with('success', 'Narxlar muvaffaqiyatli yangilandi!');
    }

}
