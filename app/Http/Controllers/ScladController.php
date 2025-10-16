<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScladTarix;
use App\Models\ScladHistory;
use App\Models\User;
use App\Models\Sclad;

class ScladController extends Controller{

    public function index(){
        $Sclad = Sclad::first();
        $User = User::get();
        $currer = 0;
        foreach ($User as $key => $value) {
            $currer = $currer + $value['idishlar'];
        }
        $ScladHistory = ScladHistory::where('status','false')->where('type','currer_chiqim')->get();
        $cur = 0;
        foreach ($ScladHistory as $key => $value) {
            $cur = $cur + $value['tayyor'] + $value['yarim_tayyor'] + $value['nosoz'] + $value['sotildi'];
        }
        $res = [
            'tayyor'=>$Sclad['tayyor'],
            'bush'=>$Sclad['yarim_tayyor'],
            'nosoz'=>$Sclad['nosoz'],
            'currer'=>$currer + $cur,
        ];
        $ScladTarix = [];
        $ScladTarixd = ScladTarix::orderBy('id', 'desc')->get();
        foreach ($ScladTarixd as $key => $value) {
            $ScladTarix[$key]['status'] = $value->status;
            $ScladTarix[$key]['idishlar'] = $value->idishlar;
            $ScladTarix[$key]['nosoz_idish'] = $value->nosoz_idish;
            $ScladTarix[$key]['name'] = User::find($value->user_id)->name;
            $ScladTarix[$key]['comment'] = $value->comment;
            $ScladTarix[$key]['created_at'] = $value->created_at;
        }
        return view('sclad.index',compact('ScladTarix','res'));
    }

    public function sclad_add(Request $request){
        $request->validate([
            'idishlar' => 'required|integer|min:1',
            'comment' => 'required|string|min:3|max:255',
        ]);
        ScladTarix::create([
            'idishlar' => $request->idishlar,
            'nosoz_idish' => 0,
            'user_id' => auth()->user()->id,
            'status' => 'kirim',
            'comment' => $request->comment,
        ]);
        $Sclad = Sclad::first();
        $Sclad->yarim_tayyor = $Sclad->yarim_tayyor + $request->idishlar;
        $Sclad->save();
        return back()->with('success', 'Skladga yangi idish qo\'shildi.');
    }

    public function sclad_delete(Request $request){
        $request->validate([
            'idishlar' => 'required|integer|min:0',
            'nosoz_idish' => 'required|integer|min:0',
            'comment' => 'required|string|min:3|max:255',
        ]);
        if ($request->idishlar == 0 && $request->nosoz_idish == 0) {
            return back()->with('error', 'Chiqim maʼlumotlari toʻliq kiritilmadi.');
        }
        ScladTarix::create([
            'idishlar' => $request->idishlar,
            'nosoz_idish' => $request->nosoz_idish,
            'user_id' => auth()->user()->id,
            'status' => 'chiqim',
            'comment' => $request->comment,
        ]);
        $Sclad = Sclad::first();
        $Sclad->yarim_tayyor = $Sclad->yarim_tayyor - $request->idishlar;
        $Sclad->nosoz = $Sclad->nosoz - $request->nosoz_idish;
        $Sclad->save();
        return back()->with('success', 'Sklad chiqim qilindi.');
    }

    public function sclad_currer(){
        $history = ScladHistory::whereIn('type', ['currer_kirim', 'currer_chiqim'])->orderBy('id', 'desc')->limit(50)->get();
        $res = [];
        foreach ($history  as $key => $value) {
            if ($value->type === 'currer_chiqim' && $value->status === 'false') {
                $res[$key]['omborchi'] = '';
            } else {
                $res[$key]['omborchi'] = User::find($value->omborchi_id)->name;
            }
            $res[$key]['xaydovchi'] = User::find($value->user_id)->name;
            if($value->type=='currer_kirim'){
                $res[$key]['type'] = "Ombordan chiqim";
            }else{
                $res[$key]['type'] = "Omborga kirim";
            }
            if($value->status=='true'){
                $res[$key]['status'] = "Tasdiqlandi";
            }else{
                $res[$key]['status'] = "Tasdiqlash kutilmoqda";
            }
            $res[$key]['tayyor'] = $value->tayyor;
            $res[$key]['yarim_tayyor'] = $value->yarim_tayyor;
            $res[$key]['nosoz'] = $value->nosoz;
            $res[$key]['sotildi'] = $value->sotildi;
            $res[$key]['summa_naqt'] = $value->summa_naqt;
            $res[$key]['summa_plastik'] = $value->summa_plastik;
            $res[$key]['comment'] = $value->comment;
            $res[$key]['created_at'] = $value->created_at;
        }
        return view('sclad.currer',compact('res'));
    }

}
