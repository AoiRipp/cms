<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\PropertyAttributeController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SettingController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Route::get('/products', function () {
    //     return view('dashboard.products');
    // })->name('products');

    Route::get('/settings', function () {
        return view('dashboard.settings');
    })->name('settings');

    Route::resource('categories', CategoryController::class);
    Route::resource('promos', PromoController::class);
    Route::resource('attributes', PropertyAttributeController::class);
    Route::resource('facilities', FacilityController::class);
    Route::resource('provinces', ProvinceController::class);
    Route::resource('regencies', RegencyController::class);
    Route::resource('products', ProductController::class);
    Route::delete('products/{product}/images/{image}', [ProductController::class, 'destroyImage'])
    ->name('products.images.destroy');
    Route::get('/get-regencies/{province_id}', [LocationController::class, 'getRegencies'])->name('getRegencies');
    Route::get('/product/{metalink}', [\App\Http\Controllers\ProductController::class, 'show'])
    ->name('products.metalink');
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

?>