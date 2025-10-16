<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AuthController,OmborIdishController,KassaController};

Route::post('/login-currer', [AuthController::class, 'login_currer']); // Haydavchilar uchun
Route::post('/login-opertor', [AuthController::class, 'login_opertor']); // Operatorlar uchun
Route::post('/login-omborchi', [AuthController::class, 'login_omborchi']); // Omborchilar uchun
Route::post('/login-admin', [AuthController::class, 'login_admin']); // Administratorlar uchun
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/check-token', [AuthController::class, 'check_token']); // Tokenni tekshirish
});
// Omborxona
Route::middleware('auth:sanctum')->group(function () {
    // Omborchi
    Route::post('/chiqim-idish', [OmborIdishController::class, 'chiqim_idish']); // Ombordan haydovchiga chiqim qilish
    Route::post('/chiqim-delete', [OmborIdishController::class, 'chiqim_delete']); // Ombordan tasdiqlanmagan chiqimni o'chirish
    Route::post('/currer-chiqim-success', [OmborIdishController::class, 'currer_chiqim_success']); // Omborchi xaydovchidan maxsulotlarni qabul qilib oldi

    // Xaydovchi
    Route::post('/currer-kirim-success', [OmborIdishController::class, 'currer_kirim_success']); // Haydovchi ombordan maxsulotni qabul qilish
    Route::post('/currer-chiqim-pedding', [OmborIdishController::class, 'currer_chiqim_pedding']); // Haydovchi omborga maxsulotni qaytarib topshirish
    Route::post('/currer-chiqim-cancel', [OmborIdishController::class, 'currer_chiqim_cancel']); // Omborga maxsulotni qaytarishni bekor qilish

});
// Kassa
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/kassa-about', [KassaController::class, 'kassa_about']); // Kassa haqida
    Route::get('/kassa-history', [KassaController::class, 'kassa_history']); // Kassada tasdiqlangan chiqimlar
    Route::post('/kassa-chiqim', [KassaController::class, 'kassa_chiqim']); // Kassadan chiqim qilish
    Route::post('/kassa-chiqim-success', [KassaController::class, 'kassa_chiqim_success']); // Kassadan chiqimni tasdiqlash
    Route::post('/kassa-chiqim-cancel', [KassaController::class, 'kassa_chiqim_cancel']); // Kassadan chiqimni bekor qilish

});


