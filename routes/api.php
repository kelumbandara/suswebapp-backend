<?php

use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\api\CalculationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommonControllers\ComPermissionController;
use App\Http\Controllers\CommonControllers\DepartmentController;
use App\Http\Controllers\CommonControllers\FactoryController;
use App\Http\Controllers\CommonControllers\JobPositionController;
use App\Http\Controllers\CommonControllers\PersonTypeController;
use App\Http\Controllers\CommonControllers\UserTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentCategoryController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentInjuryTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentPeopleController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentRecordController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentWitnessController;
use App\Http\Controllers\HealthAndSaftyControllers\AiIncidentFactorsController;
use App\Http\Controllers\HealthAndSaftyControllers\AiIncidentRecodeController;
use App\Http\Controllers\HealthAndSaftyControllers\AiIncidentTypeOfConcernController;
use App\Http\Controllers\HealthAndSaftyControllers\AiIncidentTypeOfNearMissController;
use App\Http\Controllers\HealthAndSaftyControllers\ClinicalSuiteRecodeController;
use App\Http\Controllers\HealthAndSaftyControllers\CsConsultingDoctorController;
use App\Http\Controllers\HealthAndSaftyControllers\CsDesignationController;
use App\Http\Controllers\HealthAndSaftyControllers\CsMedicineStockController;
use App\Http\Controllers\HealthAndSaftyControllers\DocumentDocumentTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\DocumentRecodeController;
use App\Http\Controllers\HealthAndSaftyControllers\HazardAndRiskController;
use App\Http\Controllers\HealthAndSaftyControllers\HrCategoryController;
use App\Http\Controllers\HealthAndSaftyControllers\HrDivisionController;
use App\Http\Controllers\HealthAndSaftyControllers\OsMiMedicineNameController;
use App\Http\Controllers\HealthAndSaftyControllers\OsMiMedicineNameFormController;
use App\Http\Controllers\HealthAndSaftyControllers\OsMiMedicineRequestController;
use App\Http\Controllers\HealthAndSaftyControllers\OsMiMedicineTypeController;
use App\Http\Controllers\ProcessTypeController;

use App\Http\Controllers\UserController;
use App\Repositories\All\AccidentCategory\AccidentCategoryInterface;
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

Route::get('person-types', [PersonTypeController::class, 'index']);
Route::post('person-types', [PersonTypeController::class, 'store']);

Route::post('accident-categories', [AiAccidentCategoryController::class, 'store']);
Route::get('accident-categories', [AiAccidentCategoryController::class, 'getCategories']);
Route::get('accident-categories/{categoryName}/subcategories', [AiAccidentCategoryController::class, 'getSubcategories']);


Route::get('accident-types', [AiAccidentTypeController::class, 'index']);
Route::post('accident-types', [AiAccidentTypeController::class, 'store']);

Route::get('accident-injury', [AiAccidentInjuryTypeController::class, 'index']);
Route::post('accident-injury', [AiAccidentInjuryTypeController::class, 'store']);




Route::get('hazard-and-risk', [HazardAndRiskController::class, 'index']);
Route::post('hazard-and-risk', [HazardAndRiskController::class, 'store']);
Route::get('hazard-risk/{id}/show', [HazardAndRiskController::class, 'show']);
Route::put('hazard-risk/{id}/update', [HazardAndRiskController::class, 'update']);
Route::delete('hazard-risk/{id}/delete', [HazardAndRiskController::class, 'destroy']);
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
Route::get('accidents/{id}/show', [AiAccidentRecordController::class, 'show']);
Route::put('accidents/{id}/update', [AiAccidentRecordController::class, 'update']);
Route::delete('accidents/{id}/delete', [AiAccidentRecordController::class, 'destroy']);

Route::get('incidents', [AiIncidentRecodeController::class, 'index']);
Route::post('incidents', [AiIncidentRecodeController::class, 'store']);
Route::delete('incidents/{id}/delete', [AiIncidentRecodeController::class, 'destroy']);


Route::get('incident-types-nearMiss', [AiIncidentTypeOfNearMissController::class, 'index']);
Route::post('incident-types-nearMiss', [AiIncidentTypeOfNearMissController::class, 'store']);

Route::get('incident-types-concern', [AiIncidentTypeOfConcernController::class, 'index']);
Route::post('incident-types-concern', [AiIncidentTypeOfConcernController::class, 'store']);

Route::get('incident-factors', [AiIncidentFactorsController::class, 'index']);
Route::post('incident-factors', [AiIncidentFactorsController::class, 'store']);

Route::get('documents', [DocumentRecodeController::class, 'index']);
Route::post('documents', [DocumentRecodeController::class, 'store']);
Route::get('documents/{id}/show', [DocumentRecodeController::class, 'show']);
Route::put('documents/{id}/update', [DocumentRecodeController::class, 'update']);
Route::delete('documents/{id}/delete', [DocumentRecodeController::class, 'destroy']);

Route::get('documents-types', [DocumentDocumentTypeController::class, 'index']);
Route::post('documents-types', [DocumentDocumentTypeController::class, 'store']);

Route::get('clinical-suite', [ClinicalSuiteRecodeController::class, 'index']);
Route::post('clinical-suite', [ClinicalSuiteRecodeController::class, 'store']);
Route::put('clinical-suite/{id}/update', [ClinicalSuiteRecodeController::class, 'update']);
Route::delete('clinical-suite/{id}/delete', [ClinicalSuiteRecodeController::class, 'destroy']);

Route::get('designations', [CsDesignationController::class, 'index']);
Route::post('clinical-suite-types', [CsDesignationController::class, 'store']);
Route::put('designations/{id}/update', [CsDesignationController::class, 'update']);
Route::delete('designations/{id}/delete', [CsDesignationController::class, 'destroy']);

Route::get('consulting-doctors', [CsConsultingDoctorController::class, 'index']);
Route::post('consulting-doctors', [CsConsultingDoctorController::class, 'store']);
Route::put('consulting-doctors/{id}/update', [CsConsultingDoctorController::class, 'update']);
Route::delete('consulting-doctors/{id}/delete', [CsConsultingDoctorController::class, 'destroy']);

Route::get('medicine-stock', [CsMedicineStockController::class, 'index']);
Route::post('medicine-stock', [CsMedicineStockController::class, 'store']);
Route::put('medicine-stock/{id}/update', [CsMedicineStockController::class, 'update']);
Route::delete('medicine-stock/{id}/delete', [CsMedicineStockController::class, 'destroy']);

Route::get('medicine-request', [OsMiMedicineRequestController::class, 'index']);
Route::post('medicine-request', [OsMiMedicineRequestController::class, 'store']);
Route::put('medicine-request/{id}/update', [OsMiMedicineRequestController::class, 'update']);
Route::delete('medicine-request/{id}/delete', [OsMiMedicineRequestController::class, 'destroy']);

Route::get('medicine-name', [OsMiMedicineNameController::class, 'index']);
Route::post('medicine-name', [OsMiMedicineNameController::class, 'store']);
Route::put('medicine-name/{id}/update', [OsMiMedicineNameController::class, 'update']);
Route::delete('medicine-name/{id}/delete', [OsMiMedicineNameController::class, 'destroy']);

Route::get('medicine-form', [OsMiMedicineNameFormController::class, 'index']);
Route::post('medicine-form', [OsMiMedicineNameFormController::class, 'store']);
Route::put('medicine-form/{id}/update', [OsMiMedicineNameFormController::class, 'update']);
Route::delete('medicine-form/{id}/delete', [OsMiMedicineNameFormController::class, 'destroy']);

Route::get('medicine-types', [OsMiMedicineTypeController::class, 'index']);
Route::post('medicine-types', [OsMiMedicineTypeController::class, 'store']);
Route::put('medicine-types/{id}/update', [OsMiMedicineTypeController::class, 'update']);
Route::delete('medicine-types/{id}/delete', [OsMiMedicineTypeController::class, 'destroy']);


Route::get('user-permissions', [ComPermissionController::class, 'index']);
Route::post('user-permissions', [ComPermissionController::class, 'store']);
Route::get('user-permissions/{id}/show', [ComPermissionController::class, 'show']);
Route::put('user-permissions/{id}/update', [ComPermissionController::class, 'update']);
Route::delete('user-permissions/{id}/delete', [ComPermissionController::class, 'destroy']);


Route::middleware('auth:sanctum')->get('user', [UserController::class, 'show']);
