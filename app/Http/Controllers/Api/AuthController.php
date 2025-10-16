<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller{

    public function login_currer(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:4',
        ]);
        $user = User::where('email', $request->email)->where('status', 'true')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login yoki parol xato.'
            ], 401);
        }
        if ($user->type != 'superadmin' && $user->type != 'admin' && $user->type != 'currer') {
            return response()->json([
                'success' => false,
                'message' => 'Sizga bu ilovaga kirishga ruxsat berilmagan.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Tizimga muvaffaqiyatli kirdingiz.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'type' => $user->type,
            ]
        ]);
    }

    public function login_opertor(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:4',
        ]);
        $user = User::where('email', $request->email)->where('status', 'true')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login yoki parol xato.'
            ], 401);
        }
        if ($user->type != 'superadmin' && $user->type != 'admin' && $user->type != 'operator') {
            return response()->json([
                'success' => false,
                'message' => 'Sizga bu ilovaga kirishga ruxsat berilmagan.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Tizimga muvaffaqiyatli kirdingiz.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'type' => $user->type,
            ]
        ]);
    }

    public function login_omborchi(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:4',
        ]);
        $user = User::where('email', $request->email)->where('status', 'true')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login yoki parol xato.'
            ], 401);
        }
        if ($user->type != 'superadmin' && $user->type != 'admin' && $user->type != 'omborchi') {
            return response()->json([
                'success' => false,
                'message' => 'Sizga bu ilovaga kirishga ruxsat berilmagan.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Tizimga muvaffaqiyatli kirdingiz.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'type' => $user->type,
            ]
        ]);
    }

    public function login_admin(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:4',
        ]);
        $user = User::where('email', $request->email)->where('status', 'true')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login yoki parol xato.'
            ], 401);
        }

        if ($user->type != 'superadmin' && $user->type != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sizga bu ilovaga kirishga ruxsat berilmagan.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Tizimga muvaffaqiyatli kirdingiz.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'type' => $user->type,
            ]
        ]);
    }

    public function user(Request $request){
        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Tizimdan chiqildi.'
        ]);
    }

    public function check_token(Request $request){
        $user = $request->user();
        if (!$user || !$request->user()->currentAccessToken()) {
            return response()->json([
                'success' => false,
                'message' => 'Token yaroqsiz yoki foydalanuvchi aniqlanmadi.'
            ], 401);
        }
        return response()->json([
            'success' => true,
            'user' => "Token aktiv holatda",
        ]);
    }

}
