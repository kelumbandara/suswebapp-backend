<?php

use App\Http\Controllers\api\CalculationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HazardRiskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('calculate', [CalculationController::class, 'store']);
Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [LoginController::class, 'login']);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);


Route::post('hazard-risk', [HazardRiskController::class, 'store']);
Route::get('hazard-risk', [HazardRiskController::class, 'index']);
Route::put('hazard-risk/{id}', [HazardRiskController::class, 'update']);


Route::get('documents', [DocumentController::class, 'index']);
Route::post('documents', [DocumentController::class, 'store']);
// Route::get('documents/{id}', [DocumentController::class, 'show']);
Route::put('documents/{id}', [DocumentController::class, 'update']);
// Route::delete('documents/{id}', [DocumentController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'show']);
