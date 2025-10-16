<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paymart;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HodimController extends Controller{
    // Hodimlar
    public function employees(){
        $users_active = User::where('status','true')->where('type','!=','superadmin')->select('id','name','phone','email','type','balans','currer_balans','idishlar')->get();
        $users_delete = User::where('status','!=','true')->where('type','!=','superadmin')->select('id','name','phone','email','type','balans','currer_balans','idishlar')->get();
        return response()->json([
            'success' => true,
            'message' => 'Hodimalar.',
            'activ'    => $users_active,
            'delete'    => $users_delete,
        ], 201);
    }
    // Hodim statusini yangilash
    public function employee_status_update(Request $request){
        $validated = $request->validate([
            'id' => 'required|numeric|min:0'
        ]);
        $id = $request->id;
        $user = User::find($id);
        if($user->status=='true'){
            $user->status = 'false';
        }else{
            $user->status = 'true';
        }
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Hodim statusi yangilandi.',
        ], 201);
    }
    // Yangi hodim qo'shish
    public function employee_create(Request $request){
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'phone' => ['required', 'min:16', 'max:16', 'unique:users,phone'],
            'type' => ['required', 'in:admin,operator,omborchi,currer'],
        ]);
        $user = new User();
        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->type = $validated['type'];
        $user->email = time()."@crm.uz";
        $user->password = Hash::make('password');
        $user->balans = 0;
        $user->currer_balans = 0;
        $user->status = 'true';
        $user->idishlar = 0;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Yangi hodim qo\'shildi.',
            "data" => $user,
        ], 201);
    }
    // Hodim haqida
    public function employee($id){
        $user = User::find($id);
        $tulovlar = Paymart::where('user_id', $id)->get();
        $paymarts = [];
        foreach($tulovlar as $key => $value) {
            $paymarts[$key]['id'] = $value->id;
            $paymarts[$key]['summa'] = $value->summa;
            $paymarts[$key]['type'] = $value->type;
            $paymarts[$key]['comment'] = $value->comment;
            $paymarts[$key]['name'] = User::find($value->admin_id)->name;
            $paymarts[$key]['created_at'] = $value->created_at;
        }
        return response()->json([
            'success' => true,
            'message' => 'Hodim haqida.',
            "hodim" => $user,
            "tulovlar" => $paymarts,
        ], 201);
    }
    // Hodim parolini yangilash
    public function employee_password_update(Request $request){
        $validated = $request->validate([
            'id' => ['required']
        ]);
        $user = User::findOrFail($request->id);
        $user->password = Hash::make('password');
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Hodim yangi paroli "password" ga yangilandi',
        ], 201);
    }
    // Hodim ish haqini to'lash
    public function employee_add_paymart(Request $request){
        $validated = $request->validate([
            'id' => ['required'],
            'amount' => ['required', 'numeric'],
            'type' => ['required', 'in:naqt,plastik'],
            'description' => ['required', 'string'],
        ]);

        Paymart::create([
            'user_id' => $validated['id'],
            'summa' => $validated['amount'],
            'type' => $validated['type'],
            'comment' => $validated['description'],
            'admin_id' => auth()->user()->id,
        ]);

        $user = User::find($validated['id']);
        $user->balans += $validated['amount'];
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Hodimga ish haqi to\'landi.',
        ], 201);
    }
    // Hodim malumotlarini yangilash
    public function employee_update(Request $request){
        $user = User::findOrFail($request->id);
        $validated = $request->validate([
            'id' => ['required'],
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'phone' => ['required','unique:users,phone,' . $user->id,],
            'type' => ['required', 'in:admin,operator,omborchi,currer'],
        ]);
        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'type' => $validated['type'],
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Hodim malumotlari yangilandi.',
        ], 201);
    }
}
