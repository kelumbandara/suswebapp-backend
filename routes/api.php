<?php

use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\api\CalculationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommonControllers\DepartmentController;
use App\Http\Controllers\CommonControllers\FactoryController;
use App\Http\Controllers\CommonControllers\JobPositionController;
use App\Http\Controllers\CommonControllers\UserTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentPeopleController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentRecordController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentWitnessController;
use App\Http\Controllers\HealthAndSaftyControllers\HazardAndRiskController;
use App\Http\Controllers\HealthAndSaftyControllers\HrCategoryController;
use App\Http\Controllers\HealthAndSaftyControllers\HrDivisionController;
use App\Http\Controllers\ProcessTypeController;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('calculate', [CalculationController::class, 'store']);
Route::post('register', [RegisteredUserController::class, 'store']);

Route::post('admin', [AdminController::class, 'index']);

Route::get('all-users', [UserController::class, 'index']);

Route::post('login', [LoginController::class, 'login']);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'otpVerifyFunction']);

Route::get('job-positions', [JobPositionController::class, 'index']);
Route::post('job-positions', [JobPositionController::class, 'store']);

Route::get('user-types', [UserTypeController::class, 'index']);
Route::post('user-types', [UserTypeController::class, 'store']);

Route::post('departments', [DepartmentController::class, 'store']);
Route::get('departments', [DepartmentController::class, 'index']);

Route::get('factory', [FactoryController::class, 'show']);
Route::post('factory', [FactoryController::class, 'store']);

Route::get('hazard-and-risk', [HazardAndRiskController::class, 'index']);
Route::post('hazard-and-risk', [HazardAndRiskController::class, 'store']);
Route::get('hazard-risk/{id}', [HazardAndRiskController::class, 'show']);
Route::put('hazard-risk/{id}', [HazardAndRiskController::class, 'update']);
Route::delete('hazard-risk/{id}', [HazardAndRiskController::class, 'destroy']);
Route::get('hazard-risk/{id}/edit', [HazardAndRiskController::class, 'edit']);


Route::get('hr-categories', [HrCategoryController::class, 'index']);
Route::post('hr-categories', [HrCategoryController::class, 'store']);
Route::get('categories', [HrCategoryController::class, 'getcategories']);
Route::get('categories/{categoryName}/subcategories', [HrCategoryController::class, 'getSubcategories']);
Route::get('subcategories/{subcategories}/observations', [HrCategoryController::class, 'getObservations']);
Route::post('store-observation', [HrCategoryController::class, 'storeObservation']);
Route::get('hr-divisions', [HrDivisionController::class, 'index']);
Route::post('hr-divisions', [HrDivisionController::class, 'store']);

Route::get('accidents', [AiAccidentRecordController::class, 'index']);
Route::post('accidents', [AiAccidentRecordController::class, 'store']);
Route::get('accidents/{id}', [AiAccidentRecordController::class, 'show']);
Route::put('accidents/{id}', [AiAccidentRecordController::class, 'update']);
Route::delete('accidents/{id}', [AiAccidentRecordController::class, 'destroy']);

Route::get('accident-witnesses', [AiAccidentWitnessController::class, 'index']);
Route::post('accident-witnesses', [AiAccidentWitnessController::class, 'store']);
Route::get('accident-witnesses/{id}', [AiAccidentWitnessController::class, 'show']);
Route::delete('accident-witnesses/{id}', [AiAccidentWitnessController::class, 'destroy']);

Route::get('accident-people', [AiAccidentPeopleController::class, 'index']);
Route::post('accident-people', [AiAccidentPeopleController::class, 'store']);
Route::get('accident-people/{id}', [AiAccidentPeopleController::class, 'show']);
Route::put('accident-people/{id}', [AiAccidentPeopleController::class, 'update']);
Route::delete('accident-people/{id}', [AiAccidentPeopleController::class, 'destroy']); 



Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'show']);
