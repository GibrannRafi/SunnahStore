<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    BarangCategory,
    CategoryController,
};

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/store-category', [CategoryController::class, 'store']);
Route::get('/get-category', [CategoryController::class, 'index']);


Route::post('/store-barang', [BarangController::class, 'store']);

Route::post('/login', [AuthController::class, 'login']);
Route::get('/get-user', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
