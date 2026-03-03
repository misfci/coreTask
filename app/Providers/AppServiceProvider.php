<?php

namespace App\Providers;

use App\Services\TaxService;
use App\Services\Tax\Strategies\VatTax;
use App\Services\Tax\Strategies\MunicipalTax;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TaxService::class, function ($app) {
            $service = new TaxService();
            $service->addCalculator(new VatTax());
            $service->addCalculator(new MunicipalTax());
            return $service;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
