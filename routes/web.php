<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HodimlarController;
use App\Http\Controllers\ScladController;
use App\Http\Controllers\KassaController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard', [HomeController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/setting-region', [SettingController::class, 'region'])->middleware('auth')->name('setting_region');
Route::get('/setting-price', [SettingController::class, 'price'])->middleware('auth')->name('setting_price');

Route::post('/setting-price-update', [SettingController::class, 'update_price'])->middleware('auth')->name('setting_price_update');
Route::post('/setting-region-create', [SettingController::class, 'region_create'])->middleware('auth')->name('setting_region_create');
Route::post('/setting-region-delete', [SettingController::class, 'region_delete'])->middleware('auth')->name('setting_region_delete');

Route::get('/hodimlar', [HodimlarController::class, 'index'])->middleware('auth')->name('hodimlar');
Route::get('/hodimlar/{id}', [HodimlarController::class, 'show'])->middleware('auth')->name('hodimlar_show');
Route::post('/hodimlar-status-update', [HodimlarController::class, 'hodim_status_update'])->middleware('auth')->name('hodim_status_update');
Route::post('/hodimlar-create', [HodimlarController::class, 'hodim_create'])->middleware('auth')->name('hodim_create');
Route::post('/hodimlar-update', [HodimlarController::class, 'hodim_update'])->middleware('auth')->name('hodim_update');
Route::get('/hodimlar/password/update/{id}', [HodimlarController::class, 'hodim_password_update'])->middleware('auth')->name('hodim_password_update');
Route::post('/hodimlar-crate-paymart', [HodimlarController::class, 'create_paymart'])->middleware('auth')->name('create_paymart');

Route::get('/sclad', [ScladController::class, 'index'])->middleware('auth')->name('sclad');
Route::post('/sclad-add', [ScladController::class, 'sclad_add'])->middleware('auth')->name('sclad_add');
Route::post('/sclad-delete', [ScladController::class, 'sclad_delete'])->middleware('auth')->name('sclad_delete');
Route::get('/sclad-currer', [ScladController::class, 'sclad_currer'])->middleware('auth')->name('sclad_currer');

Route::get('/kassa', [KassaController::class, 'index'])->middleware('auth')->name('kassa');
Route::post('/kassa-chiqim', [KassaController::class, 'kassa_chiqim'])->middleware('auth')->name('kassa_chiqim');
Route::post('/kassa-chiqim-success', [KassaController::class, 'kassa_chiqim_success'])->middleware('auth')->name('kassa_chiqim_success');
Route::post('/kassa-chiqim-cancel', [KassaController::class, 'kassa_chiqim_cancel'])->middleware('auth')->name('kassa_chiqim_cancel');
Route::get('/kassa-history', [KassaController::class, 'history'])->middleware('auth')->name('kassa_history');
