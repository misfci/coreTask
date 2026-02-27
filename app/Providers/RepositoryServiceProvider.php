<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


// بنستدعي الـ Interfaces والـ Eloquent اللي عملناهم
use App\Repositories\Interfaces\ContractRepositoryInterface;
use App\Repositories\Eloquent\ContractRepository;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use App\Repositories\Eloquent\InvoiceRepository;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Eloquent\PaymentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
