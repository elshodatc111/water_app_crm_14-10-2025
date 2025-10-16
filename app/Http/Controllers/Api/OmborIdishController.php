<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sclad;
use App\Models\ScladHistory;
use App\Models\Setting;
use App\Models\User;

class OmborIdishController extends Controller{
    // Omborchi xaydovchilarga maxsulotlarni chiqim qilish
    public function chiqim_idish(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'tayyor' => 'required|integer|min:1',
            'comment' => 'nullable|string|max:255',
        ]);
        $sclad = Sclad::first();
        if (!$sclad) {
            return response()->json([
                'success' => false,
                'message' => 'Ombor topilmadi.',
            ], 404);
        }
        if ($sclad->tayyor < $validated['tayyor']) {
            return response()->json([
                'success' => false,
                'message' => 'Omborda mahsulot yetarli emas.',
            ], 400);
        }
        $sclad->tayyor -= $validated['tayyor'];
        $sclad->save();
        $history = ScladHistory::create([
            'omborchi_id'   => auth()->id(),
            'user_id'       => $validated['user_id'],
            'type'          => 'currer_kirim',
            'status'        => 'false',
            'tayyor'        => $validated['tayyor'],
            'yarim_tayyor'  => 0,
            'nosoz'         => 0,
            'sotildi' => 0,
            'summa_naqt'    => 0,
            'summa_plastik' => 0,
            'comment'       => $validated['comment'] ?? '',
        ]);
        $Setting = Setting::first();
        $price = $Setting->water_price + $Setting->idish_price;
        $user = User::find($request->user_id);
        $user->idishlar += $request['tayyor'];
        $user->currer_balans += $request['tayyor'] * $price;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Ombordan chiqim amalga oshirildi.',
            'data'    => $history,
        ], 201);
    }
    // Omborchi tasdiqlanmagan maxsulotlar chiqimini bekor qilish
    public function chiqim_delete(Request $request){
        $validated = $request->validate([
            'id' => 'required|integer|exists:sclad_histories,id',
        ]);
        $ScladHistory = ScladHistory::find($request->id);
        if (!$ScladHistory) {
            return response()->json([
                'success' => false,
                'message' => 'Maxsulot topilmadi.',
            ], 404);
        }
        if($ScladHistory->status=='true'){
            return response()->json([
                'success' => false,
                'message' => 'Chiqim tasdiqlangan o\'zgartirish imkoni mavjud emas.',
            ], 400);
        }
        $sclad = Sclad::first();
        if (!$sclad) {
            return response()->json([
                'success' => false,
                'message' => 'Ombor topilmadi.',
            ], 404);
        }
        $sclad->tayyor += $ScladHistory['tayyor'];
        $sclad->save();
        $Setting = Setting::first();
        $price = $Setting->water_price + $Setting->idish_price;
        $user = User::find($ScladHistory->user_id);
        $user->idishlar -= $ScladHistory['tayyor'];
        $user->currer_balans -= $ScladHistory['tayyor'] * $price;
        $user->save();

        $ScladHistory->delete();
        return response()->json([
            'success' => true,
            'message' => 'Ombordan chiqim o\'chirildi.',
        ], 200);
    }
    // Haydovchi ombordan maxsulot olganligini tasdiqlash
    public function currer_kirim_success(Request $request){
        $validated = $request->validate([
            'id' => 'required|integer|exists:sclad_histories,id',
        ]);
        $ScladHistory = ScladHistory::find($request->id);
        if (!$ScladHistory) {
            return response()->json([
                'success' => false,
                'message' => 'Maxsulot topilmadi.',
            ], 404);
        }
        if($ScladHistory->status=='true'){
            return response()->json([
                'success' => false,
                'message' => 'Chiqim tasdiqlangan o\'zgartirish imkoni mavjud emas.',
            ], 400);
        }
        $ScladHistory->status = 'true';
        $ScladHistory->save();
        return response()->json([
            'success' => true,
            'message' => 'Xaydovchi maxsulotni qabul qilib oldi.',
        ], 200);
    }
    // Haydovchi olingan maxsulotlarni omborga qaytarish
    public function currer_chiqim_pedding(Request $request){
        $validated = $request->validate([
            'tayyor' => 'required|integer',
            'yarim_tayyor' => 'required|integer',
            'nosoz' => 'required|integer',
            'sotildi' => 'required|integer',
            'summa_naqt' => 'required|integer',
            'summa_plastik' => 'required|integer',
            'comment' => 'required|string',
        ]);
        $User = auth()->user();
        $balansda_mavjud_maxsulotlar = $User->idishlar;
        $maxsulotlar_soni = $request->tayyor + $request->yarim_tayyor + $request->nosoz + $request->sotildi;
        if($maxsulotlar_soni>$balansda_mavjud_maxsulotlar){
            return response()->json([
                'success' => false,
                'message' => 'Xaydovchi balansida yetarlicha maxsulot mavjud emas.',
            ], 400);
        }
        $Setting = Setting::first();
        $xaydovchi = User::find($User->id);
        $xaydovchi->idishlar -= $maxsulotlar_soni;
        $xaydovchi->currer_balans -=(($request->tayyor+$request->nosoz) * ($Setting->water_price+$Setting->idish_price) + ($request->yarim_tayyor*$Setting->idish_price) + $validated['summa_naqt'] + $validated['summa_plastik']);
        $xaydovchi->save();
        $history = ScladHistory::create([
            'omborchi_id'   => 1,
            'user_id'       => auth()->id(),
            'type'          => 'currer_chiqim',
            'status'        => 'false',
            'tayyor'        => $validated['tayyor'],
            'yarim_tayyor'  => $validated['yarim_tayyor'],
            'nosoz'         => $validated['nosoz'],
            'sotildi' => $validated['sotildi'],
            'summa_naqt'    => $validated['summa_naqt'],
            'summa_plastik' => $validated['summa_plastik'],
            'comment'       => $validated['comment'] ?? '',
        ]);
        return response()->json([
            'success' => true,
            'message' => $history,
        ], 200);
    }
    // Xaydovchi omborga maxsulot topshirishni bekor qilish
    public function currer_chiqim_cancel(Request $request){
        $validated = $request->validate([
            'id' => 'required|integer|exists:sclad_histories,id',
        ]);
        $User = auth()->user();
        $Setting = Setting::first();
        $maxsulot_id = $request->id;
        $ScladHistory = ScladHistory::find($maxsulot_id);
        if (!$ScladHistory) {
            return response()->json([
                'success' => false,
                'message' => 'Maxsulot topilmadi.',
            ], 404);
        }
        if($ScladHistory->status=='true'){
            return response()->json([
                'success' => false,
                'message' => 'Chiqim tasdiqlangan o\'zgartirish imkoni mavjud emas.',
            ], 400);
        }
        $xaydovchi = User::find($User->id);
        $Summa = ($ScladHistory->tayyor + $ScladHistory->nosoz)*($Setting->water_price + $Setting->idish_price) + ($ScladHistory->yarim_tayyor)*($Setting->idish_price) + $ScladHistory->summa_naqt + $ScladHistory->summa_plastik;
        $Maxsulotlar = $ScladHistory->tayyor + $ScladHistory->nosoz + $ScladHistory->yarim_tayyor + $ScladHistory->sotildi;
        $xaydovchi->idishlar += $Maxsulotlar;
        $xaydovchi->currer_balans +=$Summa;
        $xaydovchi->save();
        $ScladHistory->delete();
        return response()->json([
            'success' => true,
            'message' => 'Xaydovchi chiqim o\'chirildi.',
        ], 200);
    }
    // Omborchi Xaydovchidan maxsulotni qabul qilib olish
    public function currer_chiqim_success(Request $request){
        $validated = $request->validate([
            'id' => 'required|integer|exists:sclad_histories,id',
        ]);
        $User = auth()->user();
        $Setting = Setting::first();
        $maxsulot_id = $request->id;
        $ScladHistory = ScladHistory::find($maxsulot_id);
        if (!$ScladHistory) {
            return response()->json([
                'success' => false,
                'message' => 'Maxsulot topilmadi.',
            ], 404);
        }
        if($ScladHistory->status=='true'){
            return response()->json([
                'success' => false,
                'message' => 'Chiqim tasdiqlangan o\'zgartirish imkoni mavjud emas.',
            ], 400);
        }
        $sclad = Sclad::first();
        if (!$sclad) {
            return response()->json([
                'success' => false,
                'message' => 'Ombor topilmadi.',
            ], 404);
        }
        $sclad->tayyor += $ScladHistory->tayyor;
        $sclad->yarim_tayyor += $ScladHistory->yarim_tayyor;
        $sclad->nosoz += $ScladHistory->nosoz;
        $sclad->balans_naqt += $ScladHistory->summa_naqt;
        $sclad->balans_plastik += $ScladHistory->summa_plastik;
        $sclad->save();
        $xaydovchi_bonus = ($ScladHistory->yarim_tayyor + $ScladHistory->sotildi)*$Setting->currer_price;
        $Xaydovchi = User::find($ScladHistory->user_id);
        $Xaydovchi->balans +=$xaydovchi_bonus;
        $Xaydovchi->save();
        $ScladHistory->status = 'true';
        $ScladHistory->omborchi_id = auth()->user()->id;
        $ScladHistory->save();
        return response()->json([
            'success' => true,
            'message' => 'Omborchi xaydovchi hisobotini qabul qildi.',
        ], 200);
    }





}
