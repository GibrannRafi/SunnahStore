<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return view('auth/login');})->name('login');
Route::get('/login', function () {return view('auth/login');})->name('login2');
Route::get('/register', function () {return view('auth/register');})->name('register');
Route::post('/register', function () {return view('auth/register');})->name('register2');
Route::post('/login', [AuthController::class, "login"])->name('loginProses');

        Route::get('/dashboard', function() {return view('isidashboard');})->name('dashboard');
        Route::get('/logout', [AuthController::class, "logout"])->name('logout');