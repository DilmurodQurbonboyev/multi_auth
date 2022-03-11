<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')
    ->group(function () {

//        Route::middleware('guest:admin')->group(function () {
//            Route::get('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('admin.login');
////            Route::post('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');
//        });

        Route::get('/oneId', [App\Http\Controllers\Auth\AdminLoginController::class, 'oneId'])->name('admin.oneId');
        Route::get('/check', [App\Http\Controllers\Auth\AdminLoginController::class, 'check'])->name('admin.check');

        Route::middleware('auth:admin')->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
//            Route::get('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
        });

    });
