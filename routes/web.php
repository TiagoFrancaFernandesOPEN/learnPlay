<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Register\RegisterController;

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
//------------------------------- Basic
Route::get('/', [AuthController::class, 'homepage'])->name('homepage');

//------------------------------- Loguin
Route::group(['prefix' => 'login'], function(){
    $controller = AuthController::class;
    Route::post('/', [$controller, 'authenticate'])->name('login');
    Route::get('/logout', [$controller, 'logout'])->name('login.logout');
});

//------------------------------- Registro
Route::group(['prefix' => 'register'], function(){
    $controller = RegisterController::class;
    Route::get('/', [$controller, 'index']);
    Route::post('/complete', [$controller, 'register'])->name('register');
    Route::get('/error', [$controller, 'error'])->name('register.error');
    Route::get('/success', [$controller, 'success'])->name('register.success');
});

//------------------------------- Dashboard
Route::group(['prefix' => 'dashboard'], function(){
    $controller = AuthController::class;
    Route::get('/', [$controller, 'dashboard'])->name('dashboard');
});
