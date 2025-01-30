<?php

use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\api\CalculationController;
use App\Http\Controllers\AuditeeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommonControllers\DepartmentController;
use App\Http\Controllers\CommonControllers\FactoryController;
use App\Http\Controllers\CommonControllers\JobPositionController;
use App\Http\Controllers\CommonControllers\UserTypeController;
use App\Http\Controllers\FactoryDeatail\FactoryPersonController;
use App\Http\Controllers\HazardRiskController;
use App\Http\Controllers\ProcessTypeController;
use App\Http\Controllers\SustainabilityApps\ExternalAuditController;
use App\Http\Controllers\SustainabilityApps\InternalAuditController;
use App\Http\Controllers\SustainabilityApps\SDGReportingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('calculate', [CalculationController::class, 'store']);
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('users', [AdminController::class, 'index']);

Route::post('login', [LoginController::class, 'login']);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);

Route::get('job-positions', [JobPositionController::class, 'index']);
Route::post('job-positions', [JobPositionController::class, 'store']);

Route::get('user-types', [UserTypeController::class, 'index']);
Route::post('user-types', [UserTypeController::class, 'store']);

Route::post('departments', [DepartmentController::class, 'store']);
Route::get('departments', [DepartmentController::class, 'show']);

Route::get('auditees', [AuditeeController::class, 'show']);
Route::post('auditees', [AuditeeController::class, 'store']);

Route::get('process-types', [ProcessTypeController::class, 'show']);
Route::post('process-types', [ProcessTypeController::class, 'store']);

Route::get('factory', [FactoryController::class, 'show']);
Route::post('factory', [FactoryController::class, 'store']);

Route::get('factory-people', [FactoryPersonController::class, 'show']);
Route::post('factory-people', [FactoryPersonController::class, 'store']);















Route::post('hazard-risk', [HazardRiskController::class, 'store']);
Route::get('hazard-risk', [HazardRiskController::class, 'index']);
Route::put('hazard-risk/{id}', [HazardRiskController::class, 'update']);

Route::get('documents', [DocumentController::class, 'index']);
Route::post('documents', [DocumentController::class, 'store']);
// Route::get('documents/{id}', [DocumentController::class, 'show']);
Route::put('documents/{id}', [DocumentController::class, 'update']);
// Route::delete('documents/{id}', [DocumentController::class, 'destroy']);

Route::get('internal-audits', [InternalAuditController::class, 'index']);
Route::post('internal-audits', [InternalAuditController::class, 'store']);
Route::get('internal-audits/{id}', [InternalAuditController::class, 'show']);
Route::put('internal-audits/{id}', [InternalAuditController::class, 'update']);
Route::delete('internal-audits/{id}', [InternalAuditController::class, 'destroy']);

Route::get('external-audits', [ExternalAuditController::class, 'index']);
Route::post('external-audits', [ExternalAuditController::class, 'store']);
Route::get('external-audits/{id}', [ExternalAuditController::class, 'show']);
Route::put('external-audits/{id}', [ExternalAuditController::class, 'update']);
Route::delete('external-audits/{id}', [ExternalAuditController::class, 'destroy']);

Route::get('sdg-reportings', [SDGReportingController::class, 'index']);
Route::post('sdg-reportings', [SDGReportingController::class, 'store']);
Route::get('sdg-reportings/{id}', [SDGReportingController::class, 'show']);
Route::put('sdg-reportings/{id}', [SDGReportingController::class, 'update']);
Route::delete('sdg-reportings/{id}', [SDGReportingController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'show']);
