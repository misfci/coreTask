<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Invoice::class => \App\Policies\InvoicePolicy::class,

        \App\Models\Contract::class => \App\Policies\InvoicePolicy::class,
    ];


    public function boot(): void
    {
    }
}
