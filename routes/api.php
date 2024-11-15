<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RevenueController;
use App\Http\Controllers\Auth\AuthController;


Route::ApiResource('revenues', RevenueController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register' ])->name('register');
Route::post('/login', [AuthController::class, 'login' ])->name('login');
Route::post('/logout', [AuthController::class, 'logout' ])->name('logout')->middleware('auth:sanctum');
