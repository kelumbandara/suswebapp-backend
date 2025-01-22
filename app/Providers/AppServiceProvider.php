<?php

namespace App\Providers;

use App\Repositories\All\Auditee\AuditeeInterface;
use App\Repositories\All\Auditee\AuditeeRepository;
use App\Repositories\All\Department\DepartmentInterface;
use App\Repositories\All\Department\DepartmentRepository;
use App\Repositories\All\FactoryDeatail\FactoryDeatailInterface;
use App\Repositories\All\FactoryDeatail\FactoryDeatailRepository;
use App\Repositories\All\FactoryPerson\FactoryPersonInterface;
use App\Repositories\All\FactoryPerson\FactoryPersonRepository;
use App\Repositories\All\HSDocuments\DocumentInterface;
use App\Repositories\All\HSDocuments\DocumentRepository;
use App\Repositories\All\HSHazardRisks\HazardRiskInterface;
use App\Repositories\All\HSHazardRisks\HazardRiskRepository;
use App\Repositories\All\ProcessType\ProcessTypeInterface;
use App\Repositories\All\ProcessType\ProcessTypeRepository;
use App\Repositories\All\SAInternalAudits\InternalAuditInterface;
use App\Repositories\All\SAInternalAudits\InternalAuditRepository;
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

        $this->app->bind(HazardRiskInterface::class, HazardRiskRepository::class);
        $this->app->bind(DocumentInterface::class, DocumentRepository::class);
        $this->app->bind(InternalAuditInterface::class, InternalAuditRepository::class);
        $this->app->bind(DepartmentInterface::class, DepartmentRepository::class);
        $this->app->bind(AuditeeInterface::class, AuditeeRepository::class);
        $this->app->bind(ProcessTypeInterface::class, ProcessTypeRepository::class);
        $this->app->bind(FactoryDeatailInterface::class, FactoryDeatailRepository::class);
        $this->app->bind(FactoryPersonInterface::class, FactoryPersonRepository::class);




    }
}
