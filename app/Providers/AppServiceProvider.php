<?php

namespace App\Providers;

use App\Repositories\All\HSDocuments\DocumentInterface;
use App\Repositories\All\HSDocuments\DocumentRepository;
use App\Repositories\All\HSHazardRisks\HazardRiskInterface;
use App\Repositories\All\HSHazardRisks\HazardRiskRepository;
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

    }
}
