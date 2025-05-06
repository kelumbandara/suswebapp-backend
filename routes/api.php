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
use App\Http\Controllers\SustainabilityAppsControllers\SaAiExternalAuditCategoryController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiExternalAuditFirmController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiExternalAuditRecodeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiExternalAuditStandardController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiExternalAuditTypeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiIaAuditTitleController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiIaAuditTypeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiIaContactPersonController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiIaInternalAuditeeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiIaProcessTypeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiIaQuestionRecodeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiIaSuplierTypeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiInternalAuditFactoryController;
use App\Http\Controllers\SustainabilityAppsControllers\SaAiInternalAuditRecodeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmChemicalFormTypeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmChemicalManagementRecodeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmCmrCommercialNameController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmCmrHazardTypeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmCmrProductStandardController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmCmrUseOfPPEController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmCmrZdhcCategoryController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmPirPositiveListController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmPirSuplierNameController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmPirTestingLabController;
use App\Http\Controllers\SustainabilityAppsControllers\SaCmPurchaseInventoryRecodeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaEmrConsumptionCategoryController;
use App\Http\Controllers\SustainabilityAppsControllers\SaEnvirementManagementRecodeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaEnvirementTargetSettingRecodeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaETsCategoryController;
use App\Http\Controllers\SustainabilityAppsControllers\SaETsSourceController;
use App\Http\Controllers\SustainabilityAppsControllers\SaSrAdditionalSDGController;
use App\Http\Controllers\SustainabilityAppsControllers\SaSrAlignmentSDGController;
use App\Http\Controllers\SustainabilityAppsControllers\SaSrIdImpactTypeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaSrMaterialityIssuesController;
use App\Http\Controllers\SustainabilityAppsControllers\SaSrMaterialityTypeController;
use App\Http\Controllers\SustainabilityAppsControllers\SaSrPillarsController;
use App\Http\Controllers\SustainabilityAppsControllers\SaSrSDGController;
use App\Http\Controllers\SustainabilityAppsControllers\SaSrSDGReportingRecodeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('calculate', [CalculationController::class, 'store']);
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('all-users', [UserController::class, 'index']);

Route::post('login', [LoginController::class, 'login']);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'otpVerifyFunction']);
Route::post('change-password', [ForgotPasswordController::class, 'changePassword']);

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

Route::middleware('auth:sanctum')->group(function () {

    Route::get('external-audit', [SaAiExternalAuditRecodeController::class, 'index']);
    Route::post('external-audit', [SaAiExternalAuditRecodeController::class, 'store']);
    Route::post('external-audit/{id}/update', [SaAiExternalAuditRecodeController::class, 'update']);
    Route::delete('external-audit/{id}/delete', [SaAiExternalAuditRecodeController::class, 'destroy']);
    Route::get('external-audit-assign-task', [SaAiExternalAuditRecodeController::class, 'assignTask']);
    Route::get('external-audit-assignee', [SaAiExternalAuditRecodeController::class, 'assignee']);

    Route::get('internal-audit', [SaAiInternalAuditRecodeController::class, 'index']);
    Route::get('internal-audit/{id}', [SaAiInternalAuditRecodeController::class, 'show']);
    Route::post('internal-audit', [SaAiInternalAuditRecodeController::class, 'store']);
    Route::post('internal-audit/{id}/update', [SaAiInternalAuditRecodeController::class, 'update']);
    Route::delete('internal-audit/{id}/delete', [SaAiInternalAuditRecodeController::class, 'destroy']);
    Route::get('internal-audit-assign-task', [SaAiInternalAuditRecodeController::class, 'assignTask']);
    Route::get('internal-audit-assignee', [SaAiInternalAuditRecodeController::class, 'assignee']);
    Route::post('internal-audit-draft', [SaAiInternalAuditRecodeController::class, 'saveDraft']);
    Route::post('internal-audit-draft/{id}/update', [SaAiInternalAuditRecodeController::class, 'updateDraft']);
    Route::post('internal-audit-scheduled', [SaAiInternalAuditRecodeController::class, 'saveSchedualed']);
    Route::post('internal-audit-scheduled/{id}/update', [SaAiInternalAuditRecodeController::class, 'shedualedUpdate']);
    Route::post('internal-audit-ongoing/{id}/update', [SaAiInternalAuditRecodeController::class, 'updateOngoing']);
    Route::post('internal-audit-action-plan/{id}/update', [SaAiInternalAuditRecodeController::class, 'actionPlanUpdate']);
    Route::delete('internal-audit-action-plan/{id}/delete', [SaAiInternalAuditRecodeController::class, 'actionPlanDelete']);
    Route::post('internal-audit-action-plan', [SaAiInternalAuditRecodeController::class, 'actionPlanStore']);
    Route::post('internal-audit-completed/{id}/update', [SaAiInternalAuditRecodeController::class, 'complete']);
    Route::get('internal-audit-completed', [SaAiInternalAuditRecodeController::class, 'getFinalAuditers']);

    Route::get('question-reports', [SaAiIaQuestionRecodeController::class, 'index']);
    Route::post('question-reports', [SaAiIaQuestionRecodeController::class, 'store']);
    Route::post('question-reports/{id}/update', [SaAiIaQuestionRecodeController::class, 'update']);
    Route::delete('question-reports/{id}/delete', [SaAiIaQuestionRecodeController::class, 'destroy']);
    Route::get('question-reports-assignee', [SaAiIaQuestionRecodeController::class, 'assignee']);

    Route::get('sdg-report', [SaSrSDGReportingRecodeController::class, 'index']);
    Route::post('sdg-report', [SaSrSDGReportingRecodeController::class, 'store']);
    Route::post('sdg-report/{id}/update', [SaSrSDGReportingRecodeController::class, 'update']);
    Route::delete('sdg-report/{id}/delete', [SaSrSDGReportingRecodeController::class, 'destroy']);
    Route::get('sdg-report-assign-task', [SaSrSDGReportingRecodeController::class, 'assignTask']);
    Route::get('sdg-report-assignee', [SaSrSDGReportingRecodeController::class, 'assignee']);

    Route::get('environment-record', [SaEnvirementManagementRecodeController::class, 'index']);
    Route::post('environment-record', [SaEnvirementManagementRecodeController::class, 'store']);
    Route::post('environment-record/{id}/update', [SaEnvirementManagementRecodeController::class, 'update']);
    Route::delete('environment-record/{id}/delete', [SaEnvirementManagementRecodeController::class, 'destroy']);
    Route::get('environment-record-assign-task', [SaEnvirementManagementRecodeController::class, 'assignTask']);
    Route::get('environment-record-assignee', [SaEnvirementManagementRecodeController::class, 'assignee']);
    Route::get('environment-record/{year}/{month}/{division}/category-quantity-sum', [SaEnvirementManagementRecodeController::class, 'monthlyCategoryQuantitySum']);
    Route::get('environment-record/{year}/{division}/category-quantity-sum', [SaEnvirementManagementRecodeController::class, 'yearlyCategoryQuantitySum']);
    Route::get('environment-record/{year}/{month}/{division}/category-source-quantity-sum', [SaEnvirementManagementRecodeController::class, 'categorySourceQuantitySum']);
    Route::get('environment-record/{year}/{month}/{division}/scope-quantity-sum', [SaEnvirementManagementRecodeController::class, 'scopeQuantitySumByFilter']);//
    Route::get('environment-record/{year}/{division}/scope-quantity-sum', [SaEnvirementManagementRecodeController::class, 'yearlyScopeQuantitySum']);
    Route::get('environment-record/{year}/{month}/{division}/water-to-waste-water-percentage', [SaEnvirementManagementRecodeController::class, 'categoryWaterToWastePercentage']);
    Route::get('environment-record/{year}/{month}/{division}/waste-water-details', [SaEnvirementManagementRecodeController::class, 'categoryWasteWaterDetails']);
    Route::get('environment-record/{year}/{month}/{division}/energy-renewable-details', [SaEnvirementManagementRecodeController::class, 'categoryEnergyRenewableDetails']);
    Route::get('environment-record/{year}/{division}/energy-record-count-monthly', [SaEnvirementManagementRecodeController::class, 'yearlyEnergyRecordCountMonthlyBreakdown']);
    Route::get('environment-record/{year}/{month}/{division}/category-record-count', [SaEnvirementManagementRecodeController::class, 'categoryRecordCount']);
    Route::get('environment-record/{year}/{month}/{division}/status-summary', [SaEnvirementManagementRecodeController::class, 'statusSummaryByYearMonthDivision']);
    Route::get('environment-record/{year}/{month}/{division}/water-ghg-by-source', [SaEnvirementManagementRecodeController::class, 'waterGhgBySource']);
    Route::get('environment-record/{year}/category-record-count-all', [SaEnvirementManagementRecodeController::class, 'allSummaryData']);


    Route::get('target-setting', [SaEnvirementTargetSettingRecodeController::class, 'index']);
    Route::post('target-setting', [SaEnvirementTargetSettingRecodeController::class, 'store']);
    Route::post('target-setting/{id}/update', [SaEnvirementTargetSettingRecodeController::class, 'update']);
    Route::delete('target-setting/{id}/delete', [SaEnvirementTargetSettingRecodeController::class, 'destroy']);
    Route::get('target-setting-assign-task', [SaEnvirementTargetSettingRecodeController::class, 'assignTask']);
    Route::get('target-setting-assignee', [SaEnvirementTargetSettingRecodeController::class, 'assignee']);

    Route::get('chemical-records', [SaCmChemicalManagementRecodeController::class, 'index']);
    Route::post('chemical-records', [SaCmChemicalManagementRecodeController::class, 'store']);
    Route::post('chemical-records/{id}/update', [SaCmChemicalManagementRecodeController::class, 'update']);
    Route::delete('chemical-records/{id}/delete', [SaCmChemicalManagementRecodeController::class, 'destroy']);
    Route::get('chemical-records-assign-task', [SaCmChemicalManagementRecodeController::class, 'assignTask']);
    Route::get('chemical-records-assignee', [SaCmChemicalManagementRecodeController::class, 'assignee']);
    Route::post('chemical-records/{id}/approve', [SaCmChemicalManagementRecodeController::class, 'approvedStatus']);

    Route::get('purchase-inventory-records', [SaCmPurchaseInventoryRecodeController::class, 'index']);
    Route::post('purchase-inventory-records/{id}/update', [SaCmPurchaseInventoryRecodeController::class, 'publishStatus']);

});

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

Route::get('external-audit-type', [SaAiExternalAuditTypeController::class, 'index']);
Route::post('external-audit-type', [SaAiExternalAuditTypeController::class, 'store']);

Route::get('external-audit-category', [SaAiExternalAuditCategoryController::class, 'index']);
Route::post('external-audit-category', [SaAiExternalAuditCategoryController::class, 'store']);

Route::get('external-audit-standard', [SaAiExternalAuditStandardController::class, 'index']);
Route::post('external-audit-standard', [SaAiExternalAuditStandardController::class, 'store']);

Route::get('external-audit-firm', [SaAiExternalAuditFirmController::class, 'index']);
Route::post('external-audit-firm', [SaAiExternalAuditFirmController::class, 'store']);

Route::get('additional-SDG', [SaSrAdditionalSDGController::class, 'index']);
Route::post('additional-SDG', [SaSrAdditionalSDGController::class, 'store']);

Route::get('alignment-SDG', [SaSrAlignmentSDGController::class, 'index']);
Route::post('alignment-SDG', [SaSrAlignmentSDGController::class, 'store']);

Route::get('impact-type', [SaSrIdImpactTypeController::class, 'index']);
Route::post('impact-type', [SaSrIdImpactTypeController::class, 'store']);
Route::get('impact-types', [SaSrIdImpactTypeController::class, 'getImpactType']);
Route::get('impact-types/{impactType}/impactUnit', [SaSrIdImpactTypeController::class, 'getImpactUnit']);

Route::get('materiality-issues', [SaSrMaterialityIssuesController::class, 'index']);
Route::post('materiality-issues', [SaSrMaterialityIssuesController::class, 'store']);

Route::get('materiality-type', [SaSrMaterialityTypeController::class, 'index']);
Route::post('materiality-type', [SaSrMaterialityTypeController::class, 'store']);

Route::get('pillars', [SaSrPillarsController::class, 'index']);
Route::post('pillars', [SaSrPillarsController::class, 'store']);

Route::get('sdg-value', [SaSrSDGController::class, 'index']);
Route::post('sdg-value ', [SaSrSDGController::class, 'store']);

Route::get('audit-factory', [SaAiInternalAuditFactoryController::class, 'index']);
Route::post('audit-factory', [SaAiInternalAuditFactoryController::class, 'store']);

Route::get('contact-people', [SaAiIaContactPersonController::class, 'index']);
Route::post('contact-people', [SaAiIaContactPersonController::class, 'store']);

Route::get('audit-types', [SaAiIaAuditTypeController::class, 'index']);
Route::post('audit-types', [SaAiIaAuditTypeController::class, 'store']);

Route::get('process-types', [SaAiIaProcessTypeController::class, 'index']);
Route::post('process-types', [SaAiIaProcessTypeController::class, 'store']);

Route::get('audit-titles', [SaAiIaAuditTitleController::class, 'index']);
Route::post('audit-titles', [SaAiIaAuditTitleController::class, 'store']);

Route::get('internal-auditee', [SaAiIaInternalAuditeeController::class, 'index']);
Route::post('internal-auditee', [SaAiIaInternalAuditeeController::class, 'store']);

Route::get('supplier-types', [SaAiIaSuplierTypeController::class, 'index']);
Route::post('supplier-types', [SaAiIaSuplierTypeController::class, 'store']);

Route::get('ts-categories', [SaETsCategoryController::class, 'index']);
Route::post('ts-categories', [SaETsCategoryController::class, 'store']);
Route::get('ts-categories', [SaETsCategoryController::class, 'getCategories']);
Route::get('categories/{categoryName}/possibilityCategory', [SaETsCategoryController::class, 'getPossibleCategories']);
Route::get('subcategories/{possibilityCategory}/opportunities', [SaETsCategoryController::class, 'getOppertunities']);

Route::get('ts-sources', [SaETsSourceController::class, 'index']);
Route::post('ts-sources', [SaETsSourceController::class, 'store']);

Route::get('consumption-categories', [SaEmrConsumptionCategoryController::class, 'index']);
Route::post('consumption-categories', [SaEmrConsumptionCategoryController::class, 'store']);
Route::get('consumption-get-categories', [SaEmrConsumptionCategoryController::class, 'getcategories']);
Route::get('consumption-get/{categoryName}/units', [SaEmrConsumptionCategoryController::class, 'getUnit']);
Route::get('consumption-get/{categoryName}/sources', [SaEmrConsumptionCategoryController::class, 'getSource']);

Route::get('commercial-names', [SaCmCmrCommercialNameController::class, 'index']);
Route::post('commercial-names', [SaCmCmrCommercialNameController::class, 'store']);

Route::get('chemical-supplier-names', [SaCmPirSuplierNameController::class, 'index']);
Route::post('chemical-supplier-names', [SaCmPirSuplierNameController::class, 'store']);

Route::get('chemical-form-types', [SaCmChemicalFormTypeController::class, 'index']);
Route::post('chemical-form-types', [SaCmChemicalFormTypeController::class, 'store']);

Route::get('zdhc-categories', [SaCmCmrZdhcCategoryController::class, 'index']);
Route::post('zdhc-categories', [SaCmCmrZdhcCategoryController::class, 'store']);

Route::get('product-standard', [SaCmCmrProductStandardController::class, 'index']);
Route::post('product-standard', [SaCmCmrProductStandardController::class, 'store']);

Route::get('hazard-types', [SaCmCmrHazardTypeController::class, 'index']);
Route::post('hazard-types', [SaCmCmrHazardTypeController::class, 'store']);

Route::get('use-of-ppes', [SaCmCmrUseOfPPEController::class, 'index']);
Route::post('use-of-ppes', [SaCmCmrUseOfPPEController::class, 'store']);

Route::get('testing-labs', [SaCmPirTestingLabController::class, 'index']);
Route::post('testing-labs', [SaCmPirTestingLabController::class, 'store']);

Route::get('positive-list', [SaCmPirPositiveListController::class, 'index']);
Route::post('positive-list', [SaCmPirPositiveListController::class, 'store']);

Route::get('image/{imageId}', [ImageUploadController::class, 'getImage']);
Route::post('upload', [ImageUploadController::class, 'uploadImage']);
Route::delete('image/{imageId}', [ImageUploadController::class, 'deleteImage']);
Route::post('image/update/{imageId}', [ImageUploadController::class, 'updateImage']);

Route::middleware('auth:sanctum')->get('user', [UserController::class, 'show']);
