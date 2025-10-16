<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klent;
use App\Models\Region;

class KlentController extends Controller{

    public function aktive_kent(Request $request){
        $query = Klent::whereIn('status', ['active', 'pedding']);
        if ($request->filled('search')) {
            $query->where('phone', 'like', '%' . $request->search . '%');
        }
        $klents = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $Region = Region::where('status','true')->get();
        return view('klent.active', compact('klents','Region'));
    }

    public function end_klent(){
        return view('klents.end');
    }
    public function show($id){


        
    }

    public function create_clent(Request $request){
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|',
            'region_id' => 'required|numeric',
            'address' => 'required|string|max:255',
            'order_count' => 'required|numeric',
        ]);
        $validated['status'] = "active";
        $validated['start_data'] = now();
        $validated['operator_id'] = auth()->user()->id;
        $validated['pedding_time'] = null;
        $validated['currer_id'] = null;
        $validated['end_time'] = null;
        Klent::create($validated);
        return back()->with('success', 'Yangi buyurtma qabul qilindi.');
    }
}
