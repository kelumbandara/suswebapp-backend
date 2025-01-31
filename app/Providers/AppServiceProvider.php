<?php

namespace App\Providers;

use App\Repositories\All\AssigneeLevel\AssigneeLevelInterface;
use App\Repositories\All\AssigneeLevel\AssigneeLevelRepository;
use App\Repositories\All\Auditee\AuditeeInterface;
use App\Repositories\All\Auditee\AuditeeRepository;
use App\Repositories\All\ComDepartment\DepartmentInterface;
use App\Repositories\All\ComDepartment\DepartmentRepository;
use App\Repositories\All\ComJobPosition\JobPositionInterface;
use App\Repositories\All\ComJobPosition\JobPositionRepository;
use App\Repositories\All\FactoryPerson\FactoryPersonInterface;
use App\Repositories\All\FactoryPerson\FactoryPersonRepository;
use App\Repositories\All\HSDocuments\DocumentInterface;
use App\Repositories\All\HSDocuments\DocumentRepository;
use App\Repositories\All\HSHazardRisks\HazardRiskInterface;
use App\Repositories\All\HSHazardRisks\HazardRiskRepository;
use App\Repositories\All\ProcessType\ProcessTypeInterface;
use App\Repositories\All\ProcessType\ProcessTypeRepository;
use App\Repositories\All\SAExternalAudits\ExternalAuditInterface;
use App\Repositories\All\SAExternalAudits\ExternalAuditRepository;
use App\Repositories\All\SAInternalAudits\InternalAuditInterface;
use App\Repositories\All\SAInternalAudits\InternalAuditRepository;
use App\Repositories\All\SDGReporting\SDGReportingInterface;
use App\Repositories\All\SDGReporting\SDGReportingRepository;
use App\Repositories\All\User\UserInterface;
use App\Repositories\All\User\UserRepository;
use App\Repositories\All\ComUserType\UserTypeInterface;
use App\Repositories\All\ComUserType\UserTypeRepository;
use App\Repositories\All\Factory\FactoryInterface;
use App\Repositories\All\Factory\FactoryRepository;
use App\Repositories\All\HazardAndRisk\HazardAndRiskInterface;
use App\Repositories\All\HazardAndRisk\HazardAndRiskRepository;
use App\Repositories\All\HRCategory\HRCategoryInterface;
use App\Repositories\All\HRCategory\HRCategoryRepository;
use App\Repositories\All\HRDivision\HRDivisionInterface;
use App\Repositories\All\HRDivision\HRDivisionRepository;
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



    }
}
