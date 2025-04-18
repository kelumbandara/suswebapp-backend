<?php

namespace App\Providers;

use App\Repositories\All\AccidentCategory\AccidentCategoryInterface;
use App\Repositories\All\AccidentCategory\AccidentCategoryRepository;
use App\Repositories\All\AccidentInjuryType\AccidentInjuryTypeInterface;
use App\Repositories\All\AccidentInjuryType\AccidentInjuryTypeRepository;
use App\Repositories\All\AccidentPeople\AccidentPeopleInterface;
use App\Repositories\All\AccidentPeople\AccidentPeopleRepository;
use App\Repositories\All\AccidentRecord\AccidentRecordInterface;
use App\Repositories\All\AccidentRecord\AccidentRecordRepository;
use App\Repositories\All\AccidentType\AccidentTypeInterface;
use App\Repositories\All\AccidentType\AccidentTypeRepository;
use App\Repositories\All\AccidentWitness\AccidentWitnessInterface;
use App\Repositories\All\AccidentWitness\AccidentWitnessRepository;
use App\Repositories\All\AssigneeLevel\AssigneeLevelInterface;
use App\Repositories\All\AssigneeLevel\AssigneeLevelRepository;
use App\Repositories\All\ClinicalSuite\ClinicalSuiteInterface;
use App\Repositories\All\ClinicalSuite\ClinicalSuiteRepository;
use App\Repositories\All\ComDepartment\DepartmentInterface;
use App\Repositories\All\ComDepartment\DepartmentRepository;
use App\Repositories\All\ComJobPosition\JobPositionInterface;
use App\Repositories\All\ComJobPosition\JobPositionRepository;
use App\Repositories\All\ComPermission\ComPermissionInterface;
use App\Repositories\All\ComPermission\ComPermissionRepository;
use App\Repositories\All\ComPersonType\PersonTypeInterface;
use App\Repositories\All\ComPersonType\PersonTypeRepository;
use App\Repositories\All\ComResponsibleSection\ComResponsibleSectionInterface;
use App\Repositories\All\ComResponsibleSection\ComResponsibleSectionRepository;
use App\Repositories\All\User\UserInterface;
use App\Repositories\All\User\UserRepository;
use App\Repositories\All\ComUserType\UserTypeInterface;
use App\Repositories\All\ComUserType\UserTypeRepository;
use App\Repositories\All\CsConsultingDoctor\ConsultingInterface;
use App\Repositories\All\CsConsultingDoctor\ConsultingRepository;
use App\Repositories\All\CsDesignation\DesignationInterface;
use App\Repositories\All\CsDesignation\DesignationRepository;
use App\Repositories\All\CsMedicineStock\MedicineStockInterface;
use App\Repositories\All\CsMedicineStock\MedicineStockRepository;
use App\Repositories\All\Factory\FactoryInterface;
use App\Repositories\All\Factory\FactoryRepository;
use App\Repositories\All\HazardAndRisk\HazardAndRiskInterface;
use App\Repositories\All\HazardAndRisk\HazardAndRiskRepository;
use App\Repositories\All\HRCategory\HRCategoryInterface;
use App\Repositories\All\HRCategory\HRCategoryRepository;
use App\Repositories\All\HRDivision\HRDivisionInterface;
use App\Repositories\All\HRDivision\HRDivisionRepository;
use App\Repositories\All\HSDocumentDocumentType\DocumentTypeInterface;
use App\Repositories\All\HSDocumentDocumentType\DocumentTypeRepository;
use App\Repositories\All\HSDocumentRecode\DocumentInterface;
use App\Repositories\All\HSDocumentRecode\DocumentRepository;
use App\Repositories\All\HsOcMrMdDocumentType\DocumentTypeInterface as HsOcMrMdDocumentTypeDocumentTypeInterface;
use App\Repositories\All\HsOcMrMdDocumentType\DocumentTypeRepository as HsOcMrMdDocumentTypeDocumentTypeRepository;
use App\Repositories\All\HsOhMrBenefitDocument\BenefitDocumentInterface;
use App\Repositories\All\HsOhMrBenefitDocument\BenefitDocumentRepository;
use App\Repositories\All\HsOhMrBenefitEntitlement\BenefitEntitlementInterface;
use App\Repositories\All\HsOhMrBenefitEntitlement\BenefitEntitlementRepository;
use App\Repositories\All\IncidentCircumstances\IncidentCircumstancesInterface;
use App\Repositories\All\IncidentCircumstances\IncidentCircumstancesRepository;
use App\Repositories\All\IncidentFactors\IncidentFactorsInterface;
use App\Repositories\All\IncidentFactors\IncidentFactorsRepository;
use App\Repositories\All\IncidentPeople\IncidentPeopleInterface;
use App\Repositories\All\IncidentPeople\IncidentPeopleRepository;
use App\Repositories\All\IncidentRecord\IncidentRecodeInterface;
use App\Repositories\All\IncidentRecord\IncidentRecodeRepository;
use App\Repositories\All\IncidentTypeOfConcern\IncidentTypeOfConcernInterface;
use App\Repositories\All\IncidentTypeOfConcern\IncidentTypeOfConcernRepository;
use App\Repositories\All\IncidentTypeOfNearMiss\IncidentTypeOfNearMissInterface;
use App\Repositories\All\IncidentTypeOfNearMiss\IncidentTypeOfNearMissRepository;
use App\Repositories\All\IncidentWitness\IncidentWitnessInterface;
use App\Repositories\All\IncidentWitness\IncidentWitnessRepository;
use App\Repositories\All\MedicineDisposal\MedicineDisposalInterface;
use App\Repositories\All\MedicineDisposal\MedicineDisposalRepository;
use App\Repositories\All\MedicineInventory\MedicineInventoryInterface;
use App\Repositories\All\MedicineInventory\MedicineInventoryRepository;
use App\Repositories\All\MiMedicineName\MedicineNameInterface;
use App\Repositories\All\MiMedicineName\MedicineNameRepository;
use App\Repositories\All\MiMedicineNameForm\MedicineFormInterface;
use App\Repositories\All\MiMedicineNameForm\MedicineFormRepository;
use App\Repositories\All\MiMedicineRequest\MedicineRequestInterface;
use App\Repositories\All\MiMedicineRequest\MedicineRequestRepository;
use App\Repositories\All\MiMedicineType\MedicineTypeInterface;
use App\Repositories\All\MiMedicineType\MedicineTypeRepository;
use App\Repositories\All\OhMiPiSupplierName\SupplierNameInterface;
use App\Repositories\All\OhMiPiSupplierName\SupplierNameRepository;
use App\Repositories\All\OhMiPiSupplierType\SupplierTypeInterface;
use App\Repositories\All\OhMiPiSupplierType\SupplierTypeRepository;
use App\Repositories\All\OhMrBeBenefitType\BenefitTypeInterface;
use App\Repositories\All\OhMrBeBenefitType\BenefitTypeRepository;
use App\Repositories\All\OhMrBenefitRequest\BenefitRequestInterface;
use App\Repositories\All\OhMrBenefitRequest\BenefitRequestRepository;
use App\Repositories\All\SaAiEaAuditCategory\ExternalAuditCategoryInterface;
use App\Repositories\All\SaAiEaAuditCategory\ExternalAuditCategoryRepository;
use App\Repositories\All\SaAiEaAuditFirm\ExternalAuditFirmInterface;
use App\Repositories\All\SaAiEaAuditFirm\ExternalAuditFirmRepository;
use App\Repositories\All\SaAiEaAuditStandard\ExternalAuditStandardInterface;
use App\Repositories\All\SaAiEaAuditStandard\ExternalAuditStandardRepository;
use App\Repositories\All\SaAiEaAuditType\ExternalAuditTypeInterface;
use App\Repositories\All\SaAiEaAuditType\ExternalAuditTypeRepository;
use App\Repositories\All\SaAiExternalAudit\ExternalAuditInterface;
use App\Repositories\All\SaAiExternalAudit\ExternalAuditRepository;
use App\Repositories\All\SaAiIaAuditTitle\AuditTitleInterface;
use App\Repositories\All\SaAiIaAuditTitle\AuditTitleRepository;
use App\Repositories\All\SaAiIaAuditType\AuditTypeInterface;
use App\Repositories\All\SaAiIaAuditType\AuditTypeRepository;
use App\Repositories\All\SaAiIaContactPerson\ContactPersonInterface;
use App\Repositories\All\SaAiIaContactPerson\ContactPersonRepository;
use App\Repositories\All\SaAiIaInternalAuditee\InternalAuditeeInterface;
use App\Repositories\All\SaAiIaInternalAuditee\InternalAuditeeRepository;
use App\Repositories\All\SaAiIaProcessType\ProcessTypeInterface;
use App\Repositories\All\SaAiIaProcessType\ProcessTypeRepository;
use App\Repositories\All\SaAiIaQrGroupRecode\GroupRecodeInterface;
use App\Repositories\All\SaAiIaQrGroupRecode\GroupRecodeRepository;
use App\Repositories\All\SaAiIaQrQuection\QuestionsInterface;
use App\Repositories\All\SaAiIaQrQuection\QuestionsRepository;
use App\Repositories\All\SaAiIaQuestionRecode\QuestionRecodeInterface;
use App\Repositories\All\SaAiIaQuestionRecode\QuestionRecodeRepository;
use App\Repositories\All\SaAiIaSupplierType\SupplierTypeInterface as SaAiIaSupplierTypeSupplierTypeInterface;
use App\Repositories\All\SaAiIaSupplierType\SupplierTypeRepository as SaAiIaSupplierTypeSupplierTypeRepository;
use App\Repositories\All\SaAiInternalAuditFactory\InternalAuditFactoryInterface;
use App\Repositories\All\SaAiInternalAuditFactory\InternalAuditFactoryRepository;
use App\Repositories\All\SaAiInternalAuditRecode\InternalAuditRecodeInterface;
use App\Repositories\All\SaAiInternalAuditRecode\InternalAuditRecodeRepository;
use App\Repositories\All\SaEmrAddConcumption\AddConcumptionInterface;
use App\Repositories\All\SaEmrAddConcumption\AddConcumptionRepository;
use App\Repositories\All\SaEnvirementManagementRecode\EnvirementManagementRecodeInterface;
use App\Repositories\All\SaEnvirementManagementRecode\EnvirementManagementRecodeRepository;
use App\Repositories\All\SaETargetSetting\TargetSettingRecodeInterface;
use App\Repositories\All\SaETargetSetting\TargetSettingRecodeRepository;
use App\Repositories\All\SaETsCategory\TsCategoryInterface;
use App\Repositories\All\SaETsCategory\TsCategoryRepository;
use App\Repositories\All\SaETsSource\TsSourceInterface;
use App\Repositories\All\SaETsSource\TsSourceRepository;
use App\Repositories\All\SaSDGRecode\SDGRecodeInterface;
use App\Repositories\All\SaSDGRecode\SDGRecodeRepository;
use App\Repositories\All\SaSrAdditionalSDG\AdditionalSDGInterface;
use App\Repositories\All\SaSrAdditionalSDG\AdditionalSDGRepository;
use App\Repositories\All\SaSrAlignmentSDG\AlignmentSDGInterface;
use App\Repositories\All\SaSrAlignmentSDG\AlignmentSDGRepository;
use App\Repositories\All\SaSrImpactDetails\ImpactDetailsInterface;
use App\Repositories\All\SaSrImpactDetails\ImpactDetailsRepository;
use App\Repositories\All\SaSrImpactType\ImpactTypeInterface;
use App\Repositories\All\SaSrImpactType\ImpactTypeRepository;
use App\Repositories\All\SaSrMaterialityIssues\MaterialityIssuesInterface;
use App\Repositories\All\SaSrMaterialityIssues\MaterialityIssuesRepository;
use App\Repositories\All\SaSrMaterialityType\MaterialityTypeInterface;
use App\Repositories\All\SaSrMaterialityType\MaterialityTypeRepository;
use App\Repositories\All\SaSrPillars\PillarsInterface;
use App\Repositories\All\SaSrPillars\PillarsRepository;
use App\Repositories\All\SaSrSDG\SrSdgInterface;
use App\Repositories\All\SaSrSDG\SrSdgRepository;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        $this->app->bind(DepartmentInterface::class, DepartmentRepository::class);
        $this->app->bind(FactoryInterface::class, FactoryRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(JobPositionInterface::class, JobPositionRepository::class);
        $this->app->bind(UserTypeInterface::class, UserTypeRepository::class);
        $this->app->bind(AssigneeLevelInterface::class, AssigneeLevelRepository::class);
        $this->app->bind(HazardAndRiskInterface::class, HazardAndRiskRepository::class);
        $this->app->bind(HRCategoryInterface::class, HRCategoryRepository::class);
        $this->app->bind(HRDivisionInterface::class, HRDivisionRepository::class);
        $this->app->bind(ComResponsibleSectionInterface::class, ComResponsibleSectionRepository::class);
        $this->app->bind(AccidentRecordInterface::class, AccidentRecordRepository::class);
        $this->app->bind(AccidentWitnessInterface::class, AccidentWitnessRepository::class);
        $this->app->bind(AccidentPeopleInterface::class, AccidentPeopleRepository::class);
        $this->app->bind(PersonTypeInterface::class, PersonTypeRepository::class);
        $this->app->bind(AccidentCategoryInterface::class, AccidentCategoryRepository::class);
        $this->app->bind(AccidentTypeInterface::class, AccidentTypeRepository::class);
        $this->app->bind(AccidentInjuryTypeInterface::class, AccidentInjuryTypeRepository::class);
        $this->app->bind(ComPermissionInterface::class, ComPermissionRepository::class);
        $this->app->bind(IncidentRecodeInterface::class, IncidentRecodeRepository::class);
        $this->app->bind(IncidentTypeOfConcernInterface::class, IncidentTypeOfConcernRepository::class);
        $this->app->bind(IncidentTypeOfNearMissInterface::class, IncidentTypeOfNearMissRepository::class);
        $this->app->bind(IncidentFactorsInterface::class, IncidentFactorsRepository::class);
        $this->app->bind(IncidentPeopleInterface::class, IncidentPeopleRepository::class);
        $this->app->bind(IncidentWitnessInterface::class, IncidentWitnessRepository::class);
        $this->app->bind(DocumentInterface::class, DocumentRepository::class);
        $this->app->bind(DocumentTypeInterface::class, DocumentTypeRepository::class);
        $this->app->bind(ClinicalSuiteInterface::class, ClinicalSuiteRepository::class);
        $this->app->bind(DesignationInterface::class, DesignationRepository::class);
        $this->app->bind(ConsultingInterface::class, ConsultingRepository::class);
        $this->app->bind(MedicineStockInterface::class, MedicineStockRepository::class);
        $this->app->bind(MedicineRequestInterface::class, MedicineRequestRepository::class);
        $this->app->bind(MedicineNameInterface::class, MedicineNameRepository::class);
        $this->app->bind(MedicineTypeInterface::class, MedicineTypeRepository::class);
        $this->app->bind(MedicineFormInterface::class, MedicineFormRepository::class);
        $this->app->bind(BenefitRequestInterface::class, BenefitRequestRepository::class);
        $this->app->bind(BenefitDocumentInterface::class, BenefitDocumentRepository::class);
        $this->app->bind(BenefitEntitlementInterface::class, BenefitEntitlementRepository::class);
        $this->app->bind(BenefitTypeInterface::class, BenefitTypeRepository::class);
        $this->app->bind(MedicineInventoryInterface::class, MedicineInventoryRepository::class);
        $this->app->bind(MedicineDisposalInterface::class, MedicineDisposalRepository::class);
        $this->app->bind(SupplierNameInterface::class, SupplierNameRepository::class);
        $this->app->bind(SupplierTypeInterface::class, SupplierTypeRepository::class);
        $this->app->bind(IncidentCircumstancesInterface::class, IncidentCircumstancesRepository::class);
        $this->app->bind(HsOcMrMdDocumentTypeDocumentTypeInterface::class, HsOcMrMdDocumentTypeDocumentTypeRepository::class);
        $this->app->bind(ExternalAuditInterface::class, ExternalAuditRepository::class);
        $this->app->bind(ExternalAuditTypeInterface::class, ExternalAuditTypeRepository::class);
        $this->app->bind(ExternalAuditCategoryInterface::class, ExternalAuditCategoryRepository::class);
        $this->app->bind(ExternalAuditStandardInterface::class, ExternalAuditStandardRepository::class);
        $this->app->bind(ExternalAuditFirmInterface::class, ExternalAuditFirmRepository::class);
        $this->app->bind(SDGRecodeInterface::class, SDGRecodeRepository::class);
        $this->app->bind(AdditionalSDGInterface::class, AdditionalSDGRepository::class);
        $this->app->bind(AlignmentSDGInterface::class,AlignmentSDGRepository ::class);
        $this->app->bind(ImpactDetailsInterface::class,ImpactDetailsRepository ::class);
        $this->app->bind(ImpactTypeInterface::class,ImpactTypeRepository ::class);
        $this->app->bind(MaterialityIssuesInterface::class, MaterialityIssuesRepository::class);
        $this->app->bind(MaterialityTypeInterface::class, MaterialityTypeRepository::class);
        $this->app->bind(PillarsInterface::class, PillarsRepository::class);
        $this->app->bind(SrSdgInterface::class, SrSdgRepository::class);
        $this->app->bind(AuditTitleInterface::class, AuditTitleRepository::class);
        $this->app->bind(AuditTypeInterface::class, AuditTypeRepository::class);
        $this->app->bind(ContactPersonInterface::class, ContactPersonRepository::class);
        $this->app->bind(InternalAuditeeInterface::class, InternalAuditeeRepository::class);
        $this->app->bind(ProcessTypeInterface::class, ProcessTypeRepository::class);
        $this->app->bind(SaAiIaSupplierTypeSupplierTypeInterface::class, SaAiIaSupplierTypeSupplierTypeRepository::class);
        $this->app->bind(InternalAuditFactoryInterface::class, InternalAuditFactoryRepository::class);
        $this->app->bind(InternalAuditRecodeInterface::class, InternalAuditRecodeRepository::class);
        $this->app->bind(QuestionRecodeInterface::class, QuestionRecodeRepository::class);
        $this->app->bind(GroupRecodeInterface::class, GroupRecodeRepository::class);
        $this->app->bind(QuestionsInterface::class, QuestionsRepository::class);
        $this->app->bind(EnvirementManagementRecodeInterface::class, EnvirementManagementRecodeRepository::class);
        $this->app->bind(AddConcumptionInterface::class, AddConcumptionRepository::class);
        $this->app->bind(TargetSettingRecodeInterface::class, TargetSettingRecodeRepository::class);
        $this->app->bind(TsCategoryInterface::class, TsCategoryRepository::class);
        $this->app->bind(TsSourceInterface::class, TsSourceRepository::class);




    }
}
