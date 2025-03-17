<?php

use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\api\CalculationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommonControllers\AssigneeLevelController;
use App\Http\Controllers\CommonControllers\ComPermissionController;
use App\Http\Controllers\CommonControllers\DepartmentController;
use App\Http\Controllers\CommonControllers\FactoryController;
use App\Http\Controllers\CommonControllers\JobPositionController;
use App\Http\Controllers\CommonControllers\PersonTypeController;
use App\Http\Controllers\CommonControllers\ResponsibleSectionController;
use App\Http\Controllers\CommonControllers\UserTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentCategoryController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentInjuryTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentRecordController;
use App\Http\Controllers\HealthAndSaftyControllers\AiAccidentTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\AiIncidentCircumstancesController;
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
use App\Http\Controllers\HealthAndSaftyControllers\HsOcMrMdDocumentTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\OhMiPiMedicineInventoryController;
use App\Http\Controllers\HealthAndSaftyControllers\OhMiPiMiSupplierNameController;
use App\Http\Controllers\HealthAndSaftyControllers\OhMiPiMiSupplierTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\OhMrBeBenefitTypeController;
use App\Http\Controllers\HealthAndSaftyControllers\OhMrBenefitRequestController;
use App\Http\Controllers\HealthAndSaftyControllers\OsMiMedicineNameController;
use App\Http\Controllers\HealthAndSaftyControllers\OsMiMedicineNameFormController;
use App\Http\Controllers\HealthAndSaftyControllers\OsMiMedicineRequestController;
use App\Http\Controllers\HealthAndSaftyControllers\OsMiMedicineTypeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('calculate', [CalculationController::class, 'store']);
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('all-users', [UserController::class, 'index']);

Route::post('login', [LoginController::class, 'login']);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'otpVerifyFunction']);
Route::post('change-password', [ForgotPasswordController::class, 'changePassword']);

Route::get('user-permissions', [ComPermissionController::class, 'index']);
Route::post('user-permissions', [ComPermissionController::class, 'store']);
Route::get('user-permissions/{id}/show', [ComPermissionController::class, 'show']);
Route::post('user-permissions/{id}/update', [ComPermissionController::class, 'update']);
Route::delete('user-permissions/{id}/delete', [ComPermissionController::class, 'destroy']);

Route::get('responsible-section', [ResponsibleSectionController::class, 'index']);
Route::post('responsible-section', [ResponsibleSectionController::class, 'store']);

Route::get('assignee-level', [AssigneeLevelController::class, 'index']);


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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users-assignee', [UserController::class, 'assignee']);

    Route::get('users', [AdminController::class, 'index']);
    Route::post('users/{id}/update', [AdminController::class, 'update']);
    Route::get('users-assignee-level', [AdminController::class, 'assigneeLevel']);


    Route::get('hazard-and-risk', [HazardAndRiskController::class, 'index']);
    Route::post('hazard-and-risk', [HazardAndRiskController::class, 'store']);
    Route::get('hazard-risk/{id}/show', [HazardAndRiskController::class, 'show']);
    Route::post('hazard-risk/{id}/update', [HazardAndRiskController::class, 'update']);
    Route::delete('hazard-risk/{id}/delete', [HazardAndRiskController::class, 'destroy']);
    Route::get('hazard-risks-assign-task', [HazardAndRiskController::class, 'assignTask']);
    Route::get('hazard-risks-assignee', [HazardAndRiskController::class, 'assignee']);
    Route::get('hazard-risk-dashboard', [HazardAndRiskController::class, 'dashboardStats']);
    Route::get('hazard-risk-dashboard-division', [HazardAndRiskController::class, 'dashboardStatsByDivision']);

    Route::get('accidents', [AiAccidentRecordController::class, 'index']);
    Route::post('accidents', [AiAccidentRecordController::class, 'store']);
    Route::get('accidents/{id}/show', [AiAccidentRecordController::class, 'show']);
    Route::post('accidents/{id}/update', [AiAccidentRecordController::class, 'update']);
    Route::delete('accidents/{id}/delete', [AiAccidentRecordController::class, 'destroy']);
    Route::get('accidents-assign-task', [AiAccidentRecordController::class, 'assignTask']);
    Route::get('accidents-assignee', [AiAccidentRecordController::class, 'assignee']);

    Route::get('incidents', [AiIncidentRecodeController::class, 'index']);
    Route::post('incidents', [AiIncidentRecodeController::class, 'store']);
    Route::post('incidents/{id}/update', [AiIncidentRecodeController::class, 'update']);
    Route::delete('incidents/{id}/delete', [AiIncidentRecodeController::class, 'destroy']);
    Route::get('incidents-assign-task', [AiIncidentRecodeController::class, 'assignTask']);
    Route::get('incidents-assignee', [AiIncidentRecodeController::class, 'assignee']);

    Route::get('documents', [DocumentRecodeController::class, 'index']);
    Route::post('documents', [DocumentRecodeController::class, 'store']);
    Route::get('documents/{id}/show', [DocumentRecodeController::class, 'show']);
    Route::post('documents/{id}/update', [DocumentRecodeController::class, 'update']);
    Route::delete('documents/{id}/delete', [DocumentRecodeController::class, 'destroy']);

    Route::get('patient-records', [ClinicalSuiteRecodeController::class, 'index']);
    Route::post('patient-records', [ClinicalSuiteRecodeController::class, 'store']);
    Route::post('patient-records/{id}/update', [ClinicalSuiteRecodeController::class, 'update']);
    Route::delete('patient-records/{id}/delete', [ClinicalSuiteRecodeController::class, 'destroy']);

    Route::get('medicine-request', [OsMiMedicineRequestController::class, 'index']);
    Route::post('medicine-request', [OsMiMedicineRequestController::class, 'store']);
    Route::post('medicine-request/{id}/update', [OsMiMedicineRequestController::class, 'update']);
    Route::delete('medicine-request/{id}/delete', [OsMiMedicineRequestController::class, 'destroy']);
    Route::get('medicine-request-assign-task', [OsMiMedicineRequestController::class, 'assignTask']);
    Route::get('medicine-request-assignee', [OsMiMedicineRequestController::class, 'assignee']);
    Route::post('medicine-request/{id}/approve', [OsMiMedicineRequestController::class, 'approvedStatus']);

    Route::get('medicine-inventory', [OhMiPiMedicineInventoryController::class, 'index']);
    Route::post('medicine-inventory', [OhMiPiMedicineInventoryController::class, 'store']);
    Route::post('medicine-inventory/{id}/update', [OhMiPiMedicineInventoryController::class, 'update']);
    Route::delete('medicine-inventory/{id}/delete', [OhMiPiMedicineInventoryController::class, 'destroy']);
    Route::post('medicine-inventory/{id}/publish', [OhMiPiMedicineInventoryController::class, 'publishedStatus']);
    Route::get('transaction-published', [OhMiPiMedicineInventoryController::class, 'published']);


    Route::get('benefit-request', [OhMrBenefitRequestController::class, 'index']);
    Route::post('benefit-request', [OhMrBenefitRequestController::class, 'store']);
    Route::post('benefit-request/{id}/update', [OhMrBenefitRequestController::class, 'update']);
    Route::delete('benefit-request/{id}/delete', [OhMrBenefitRequestController::class, 'destroy']);
});

Route::get('hr-categories', [HrCategoryController::class, 'index']);
Route::post('hr-categories', [HrCategoryController::class, 'store']);
Route::get('categories', [HrCategoryController::class, 'getcategories']);
Route::get('categories/{categoryName}/subcategories', [HrCategoryController::class, 'getSubcategories']);
Route::get('subcategories/{subcategories}/observations', [HrCategoryController::class, 'getObservations']);
Route::post('store-observation', [HrCategoryController::class, 'storeObservation']);
Route::get('hr-divisions', [HrDivisionController::class, 'index']);
Route::post('hr-divisions', [HrDivisionController::class, 'store']);

Route::get('incident-circumstances', [AiIncidentCircumstancesController::class, 'index']);
Route::post('incident-circumstances', [AiIncidentCircumstancesController::class, 'store']);
Route::post('incident-circumstances/{id}/update', [AiIncidentCircumstancesController::class, 'update']);
Route::delete('incident-circumstances/{id}/delete', [AiIncidentCircumstancesController::class, 'destroy']);

Route::get('incident-types-nearMiss', [AiIncidentTypeOfNearMissController::class, 'index']);
Route::post('incident-types-nearMiss', [AiIncidentTypeOfNearMissController::class, 'store']);

Route::get('incident-types-concern', [AiIncidentTypeOfConcernController::class, 'index']);
Route::post('incident-types-concern', [AiIncidentTypeOfConcernController::class, 'store']);

Route::get('incident-factors', [AiIncidentFactorsController::class, 'index']);
Route::post('incident-factors', [AiIncidentFactorsController::class, 'store']);

Route::get('documents-types', [DocumentDocumentTypeController::class, 'index']);
Route::post('documents-types', [DocumentDocumentTypeController::class, 'store']);

Route::get('designations', [CsDesignationController::class, 'index']);
Route::post('designations', [CsDesignationController::class, 'store']);
Route::post('designations/{id}/update', [CsDesignationController::class, 'update']);
Route::delete('designations/{id}/delete', [CsDesignationController::class, 'destroy']);

Route::get('consulting-doctors', [CsConsultingDoctorController::class, 'index']);
Route::post('consulting-doctors', [CsConsultingDoctorController::class, 'store']);
Route::post('consulting-doctors/{id}/update', [CsConsultingDoctorController::class, 'update']);
Route::delete('consulting-doctors/{id}/delete', [CsConsultingDoctorController::class, 'destroy']);

Route::get('medicine-stock', [CsMedicineStockController::class, 'index']);
Route::post('medicine-stock', [CsMedicineStockController::class, 'store']);
Route::post('medicine-stock/{id}/update', [CsMedicineStockController::class, 'update']);
Route::delete('medicine-stock/{id}/delete', [CsMedicineStockController::class, 'destroy']);

Route::get('medicine-name', [OsMiMedicineNameController::class, 'index']);
Route::post('medicine-name', [OsMiMedicineNameController::class, 'store']);
Route::post('medicine-name/{id}/update', [OsMiMedicineNameController::class, 'update']);
Route::delete('medicine-name/{id}/delete', [OsMiMedicineNameController::class, 'destroy']);

Route::get('medicine-form', [OsMiMedicineNameFormController::class, 'index']);
Route::post('medicine-form', [OsMiMedicineNameFormController::class, 'store']);
Route::post('medicine-form/{id}/update', [OsMiMedicineNameFormController::class, 'update']);
Route::delete('medicine-form/{id}/delete', [OsMiMedicineNameFormController::class, 'destroy']);

Route::get('medicine-types', [OsMiMedicineTypeController::class, 'index']);
Route::post('medicine-types', [OsMiMedicineTypeController::class, 'store']);
Route::post('medicine-types/{id}/update', [OsMiMedicineTypeController::class, 'update']);
Route::delete('medicine-types/{id}/delete', [OsMiMedicineTypeController::class, 'destroy']);

Route::get('medical-documents-types', [HsOcMrMdDocumentTypeController::class, 'index']);
Route::post('medical-documents-types', [HsOcMrMdDocumentTypeController::class, 'store']);
Route::post('medical-documents-types/{id}/update', [HsOcMrMdDocumentTypeController::class, 'update']);
Route::delete('medical-documents-types/{id}/delete', [HsOcMrMdDocumentTypeController::class, 'destroy']);

Route::get('benefit-types', [OhMrBeBenefitTypeController::class, 'index']);
Route::post('benefit-types', [OhMrBeBenefitTypeController::class, 'store']);

Route::get('supplier-name', [OhMiPiMiSupplierNameController::class, 'index']);
Route::post('supplier-name', [OhMiPiMiSupplierNameController::class, 'store']);
Route::post('supplier-name/{id}/update', [OhMiPiMiSupplierNameController::class, 'update']);
Route::delete('supplier-name/{id}/delete', [OhMiPiMiSupplierNameController::class, 'destroy']);

Route::get('supplier-type', [OhMiPiMiSupplierTypeController::class, 'index']);
Route::post('supplier-type', [OhMiPiMiSupplierTypeController::class, 'store']);
Route::post('supplier-type/{id}/update', [OhMiPiMiSupplierTypeController::class, 'update']);
Route::delete('supplier-type/{id}/delete', [OhMiPiMiSupplierTypeController::class, 'destroy']);

Route::get('image/{imageId}', [ImageUploadController::class, 'getImage']);
Route::post('upload', [ImageUploadController::class, 'uploadImage']);

Route::middleware('auth:sanctum')->get('user', [UserController::class, 'show']);
