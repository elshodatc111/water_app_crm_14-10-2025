<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sclad;
use App\Models\User;
use App\Models\ScladHistory;

class KassaController extends Controller
{
    public function kassa_about(){
        $mavjuds = Sclad::first();
        $pedding_naqt = 0;
        $pedding_plastik = 0;
        $xaydovchi_idish = 0;
        $xaydovchi_balans = 0;
        $peddin_list = [];
        $ScladHistory = ScladHistory::where('status','false')->where('type','balans_chiqim')->get();
        foreach ($ScladHistory as $key => $value) {
            $peddin_list[$key]['id'] = $value->id;
            $peddin_list[$key]['name'] = User::find($value->omborchi_id)->name;
            $peddin_list[$key]['summa_naqt'] = $value->summa_naqt;
            $peddin_list[$key]['summa_plastik'] = $value->summa_plastik;
            $peddin_list[$key]['comment'] = $value->comment;
            $peddin_list[$key]['created_at'] = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:i');
            $pedding_naqt += $value['summa_naqt'];
            $pedding_plastik += $value['summa_plastik'];
        }
        $users = User::get();
        foreach ($users as $key => $value) {
            $xaydovchi_idish += $value->idishlar;
            $xaydovchi_balans += $value->currer_balans;
        }
        $ScladHistory2 = ScladHistory::where('status','false')->where('type','currer_chiqim')->get();
        foreach ($ScladHistory2 as $key => $value) {
            $xaydovchi_idish += ($value->tayyor + $value->yarim_tayyor + $value->nosoz + $value->sotildi);
            $xaydovchi_balans += ($value->summa_naqt + $value->summa_plastik);
        }
        $mavjud = [
            'balans_naqt' => $mavjuds['balans_naqt'],
            'balans_plastik' => $mavjuds['balans_plastik'],
            'pedding_naqt' => $pedding_naqt,
            'pedding_plastik' => $pedding_plastik,
            'xaydovchi_idishlar' => $xaydovchi_idish,
            'xaydovchi_balans' => $xaydovchi_balans,
            'peddin_list' => $peddin_list,
        ];
        return response()->json([
            'success' => true,
            'message' => 'Kassa haqida.',
            'data'    => $mavjud,
        ], 201);
    }

    public function kassa_history(){
        $ScladHistory = ScladHistory::where('status','true')->where('type','balans_chiqim')->orderby('id','desc')->limit(100)->get();
        $res = [];
        foreach ($ScladHistory as $key => $value) {
            $res[$key]['omborchi'] = User::find($value->omborchi_id)->name;
            $res[$key]['summa_naqt'] = $value->summa_naqt;
            $res[$key]['summa_plastik'] = $value->summa_plastik;
            $res[$key]['comment'] = $value->comment;
            $res[$key]['created_at'] = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:i');
            $res[$key]['drejtor'] = User::find($value->user_id)->name;
        }
        return response()->json([
            'success' => true,
            'message' => 'Kassadan tasdiqlangan chiqimlar tarixi oxirgi 100 ta amaliyot.',
            'data'    => $res,
        ], 201);
    }

    public function kassa_chiqim(Request $request){
        $validated = $request->validate([
            'summa_naqt' => 'required|numeric|min:0',
            'summa_plastik' => 'required|numeric|min:0',
            'comment' => 'required|string|max:255',
        ]);
        if($request->summa_naqt==0 && $request->summa_plastik == 0){
            return response()->json([
                'success' => false,
                'message' => 'Malumotlar yetarli emas.',
            ], 402);
        }
        $Sclad = Sclad::first();
        if($Sclad->balans_naqt<$request->summa_naqt || $Sclad->balans_plastik<$request->summa_plastik){
            return response()->json([
                'success' => false,
                'message' => 'Kassada yetarli mablabg\' mavjud emas.',
            ], 402);
        }
        $Sclad->balans_naqt -= $request->summa_naqt;
        $Sclad->balans_plastik -= $request->summa_plastik;
        $Sclad->save();
        $ScladHistory = ScladHistory::create([
            'omborchi_id' => auth()->user()->id,
            'user_id' => 1,
            'type' => 'balans_chiqim',
            'status' => 'false',
            'tayyor' => 0,
            'yarim_tayyor' => 0,
            'nosoz' => 0,
            'sotildi' => 0,
            'summa_naqt' => $request->summa_naqt,
            'summa_plastik' => $request->summa_plastik,
            'comment' => $request->comment,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Kassadan tasdiqlash uchgun chiqim qilindi.',
            'data'    => $ScladHistory,
        ], 201);
    }

    public function kassa_chiqim_success(Request $request){
        $validated = $request->validate([
            'id' => 'required|numeric|min:0'
        ]);
        $ScladHistory = ScladHistory::find($request->id);
        if($ScladHistory){
            if($ScladHistory['status']=='true'){
                return response()->json([
                'success' => false,
                'message' => 'Kassadan chiqim avval tasdiqlangan.',
            ], 401);
            }
            $ScladHistory->user_id = auth()->user()->id;
            $ScladHistory->status = 'true';
            $ScladHistory->save();
            return response()->json([
                'success' => true,
                'message' => 'Kassadan chiqim tasdiqlandi.',
                'data'    => $ScladHistory,
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Kassadan chiqim topilmadi.',
            ], 401);
        }

    }
    public function kassa_chiqim_cancel(Request $request){
        $validated = $request->validate([
            'id' => 'required|numeric|min:0'
        ]);
        $ScladHistory = ScladHistory::find($request->id);
        if($ScladHistory){
            $Sclad = Sclad::first();
            $Sclad->balans_naqt += $ScladHistory->summa_naqt;
            $Sclad->balans_plastik += $ScladHistory->summa_plastik;
            $Sclad->save();
            $ScladHistory->delete();
            return response()->json([
                'success' => true,
                'message' => 'Kassadan chiqim bekor qilindi.',
                'data'    => $ScladHistory,
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Kassadan chiqim topilmadi.',
            ], 401);
        }

    }

}
