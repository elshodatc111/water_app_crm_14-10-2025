<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    OmborIdishController,
    KassaController,
    HodimController,
    RegionController,
    PriceController,
};

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

// Hodimlar
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/hodimlar', [HodimController::class, 'employees']); // Hodimlar aktiv va o'chirilgan hodimlar listi
    Route::post('/hodim-statsus-update', [HodimController::class, 'employee_status_update']); // hodim statusini yangilash
    Route::post('/hodim-create', [HodimController::class, 'employee_create']); // Yangi hodim qo'shish
    Route::get('/hodim-show/{id}', [HodimController::class, 'employee']); // hodim haqida
    Route::post('/hodim-password-update', [HodimController::class, 'employee_password_update']); // hodim parolini yangilash
    Route::post('/hodim-add-tulov', [HodimController::class, 'employee_add_paymart']); // ish haqi to'lash
    Route::post('/hodim-update', [HodimController::class, 'employee_update']); // hodim malumotlarini yangilash

});
// Region
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/region', [RegionController::class, 'region']); // Barcha hududlar
    Route::post('/region-create', [RegionController::class, 'region_create']); // Yangi hududh
    Route::post('/region-delete', [RegionController::class, 'region_delete']); // Hududni o'chirish

});
// Narxlar
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/price', [PriceController::class, 'price']); // Narxlar
    Route::post('/price-update', [PriceController::class, 'price_create']); // Narxlarni yangilash

});


