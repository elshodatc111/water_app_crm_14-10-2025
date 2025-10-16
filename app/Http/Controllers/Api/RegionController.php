<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Region;

class RegionController extends Controller{

    public function region(){
        $region = Region::where('status','true')->with('user:id,name')->get();
        $res = [];
        foreach ($region as $key => $value) {
            $res[$key]['id'] = $value['id'];
            $res[$key]['name'] = $value['name'];
            $res[$key]['created_at'] =  \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:i');
            $res[$key]['drektor'] = $value['user']['name'];
        }
        return response()->json([
            'success' => true,
            'message' => 'aktiv Hududlar.',
            'data' => $res
        ], 201);
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
        return response()->json([
            'success' => true,
            'message' => 'Yangi hudud qo\'shildi.',
        ], 201);
    }

    public function region_delete(Request $request){
        $validated = $request->validate([
            'id' => ['required'],
        ]);
        $Region = Region::find($request->id);
        $Region->status = 'delete';
        $Region->save();
        return response()->json([
            'success' => true,
            'message' => 'Hudud o\'chirildi.',
        ], 201);
    }

}
