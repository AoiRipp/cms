<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Models\Regency;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::apiResource('users', UserController::class);
Route::get('/regencies', function (Request $request) {
    $provinceId = $request->query('province_id');
    if (!$provinceId) {
        return response()->json([]);
    }
    return Regency::where('province_id', $provinceId)->get(['id', 'name']);
});
