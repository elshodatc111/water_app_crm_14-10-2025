<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klent;
use App\Models\KlentComment;
use App\Models\Region;
use App\Models\User;

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
        return view('klent.end');
    }
    public function show($id){
        $Klent = Klent::find($id);
        $klent = [
            'name'=>$Klent->name,
            'phone'=>$Klent->phone,
            'address'=>$Klent->address,
            'count'=>$Klent->order_count,
            'start'=>$Klent->start_data,
            'operator'=>User::find($Klent->operator_id)->name,
            'hudud'=>Region::find($Klent->region_id)->name,
            'status'=>$Klent->status,
            'currer_id'=>$Klent->currer_id?User::find($Klent->currer_id)->name:"-",
            'pedding_time'=>$Klent->currer_id?$Klent->pedding_time:"-",
            'end_time'=>$Klent->currer_id?$Klent->end_time:"-",
        ];
        return view('klent.show',compact('klent'));


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
