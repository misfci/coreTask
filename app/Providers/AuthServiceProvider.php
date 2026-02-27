<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // ربط موديل الفاتورة بسياسة الفواتير
        \App\Models\Invoice::class => \App\Policies\InvoicePolicy::class,
        
        // ربط موديل العقد بنفس السياسة (لأننا بنحمي فواتير العقود برضه)
        \App\Models\Contract::class => \App\Policies\InvoicePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
