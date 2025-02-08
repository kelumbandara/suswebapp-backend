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
use App\Repositories\All\MiMedicineName\MedicineNameInterface;
use App\Repositories\All\MiMedicineName\MedicineNameRepository;
use App\Repositories\All\MiMedicineNameForm\MedicineFormInterface;
use App\Repositories\All\MiMedicineNameForm\MedicineFormRepository;
use App\Repositories\All\MiMedicineRequest\MedicineRequestInterface;
use App\Repositories\All\MiMedicineRequest\MedicineRequestRepository;
use App\Repositories\All\MiMedicineType\MedicineTypeInterface;
use App\Repositories\All\MiMedicineType\MedicineTypeRepository;
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
    }
}
