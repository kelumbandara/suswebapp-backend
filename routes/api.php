<?php

use App\Http\Controllers\api\CalculationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HazardRiskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('calculate', [CalculationController::class, 'store']);
Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [LoginController::class, 'login']);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);


Route::post('hazard-risk', [HazardRiskController::class, 'store']);
Route::put('hazard-risk/{id}', [HazardRiskController::class, 'update']);



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
