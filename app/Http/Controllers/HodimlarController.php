<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paymart;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HodimlarController extends Controller{

    public function index(){
        $users_active = User::where('status','true')->where('type','!=','superadmin')->get();
        $users_delete = User::where('status','!=','true')->where('type','!=','superadmin')->get();
        return view('hodim.index',compact('users_active','users_delete'));
    }

    public function hodim_status_update(Request $request){
        $id = $request->id;
        $user = User::find($id);
        if($user->status=='true'){
            $user->status = 'false';
        }else{
            $user->status = 'true';
        }
        $user->save();
        return back()->with('success', 'So‘rov muvaffaqiyatli bajarildi.');
    }

    public function hodim_create(Request $request){
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'phone' => ['required', 'min:16', 'max:16', 'unique:users,phone'],
            'type' => ['required', 'in:admin,operator,omborchi,currer'],
        ], [
            'name.required' => 'Hodim F.I.O majburiy.',
            'name.min' => 'Hodim F.I.O kamida 3 ta belgidan iborat bo‘lishi kerak.',
            'phone.required' => 'Telefon raqami majburiy.',
            'phone.regex' => 'Telefon raqami +998 90 123 4567 bo‘lishi kerak.',
            'phone.unique' => 'Bu telefon raqam allaqachon mavjud.',
            'type.required' => 'Lavozimni tanlang.',
            'type.in' => 'Lavozim noto‘g‘ri tanlangan.',
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
        return back()->with('success', 'Yangi hodim qo\'shildi. Parol "password"');
    }

    public function show($id){
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
        return view('hodim.show',compact('user','paymarts'));
    }

    public function hodim_update(Request $request){
        $user = User::findOrFail($request->id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'phone' => [
                'required',
                'unique:users,phone,' . $user->id,
            ],
            'type' => ['required', 'in:admin,operator,omborchi,currer'],
        ], [
            'name.required' => 'Hodim F.I.O majburiy.',
            'name.min' => 'Hodim F.I.O kamida 3 ta belgidan iborat bo‘lishi kerak.',
            'phone.required' => 'Telefon raqami majburiy.',
            'phone.regex' => 'Telefon raqami +998 90 123 4567 ko\'rinishda bo\'lishi kerak.',
            'phone.unique' => 'Bu telefon raqam allaqachon boshqa hodimga biriktirilgan.',
            'type.required' => 'Lavozimni tanlang.',
            'type.in' => 'Lavozim noto‘g‘ri tanlangan.',
        ]);
        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'type' => $validated['type'],
        ]);
        return back()->with('success', "Hodim ma'lumotlari muvaffaqiyatli yangilandi.");
    }

    public function hodim_password_update($id){
        $user = User::findOrFail($id);
        $user->password = Hash::make('password');
        $user->save();
        return back()->with('success', 'Hodim paroli yangilandi. Yangi parol "password"');
    }

    public function create_paymart(Request $request){
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'type' => 'required|in:naqt,plastik',
            'description' => 'required|string|min:5|max:500',
        ], [
            'amount.required' => "To‘lov summasini kiriting.",
            'amount.numeric' => "To‘lov summasi raqam bo‘lishi kerak.",
            'amount.min' => "Minimal to‘lov summasi 1000 so‘m bo‘lishi kerak.",
            'type.required' => "To‘lov turini tanlang.",
            'type.in' => "To‘lov turi 'naqt' yoki 'plastik' bo‘lishi kerak.",
            'description.required' => "To‘lov haqida ma’lumot kiriting.",
            'description.min' => "To‘lov haqida kamida 5 ta belgi kiriting.",
        ]);
        Paymart::create([
            'user_id' => $request->id,
            'summa' => $validated['amount'],
            'type' => $validated['type'],
            'comment' => $validated['description'],
            'admin_id' => auth()->user()->id
        ]);
        $user = User::find($request->id);
        $user->balans = $user->balans-$validated['amount'];
        $user->save();
        return back()->with('success', "To‘lov muvaffaqiyatli saqlandi.");
    }



}
