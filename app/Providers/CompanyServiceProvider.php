<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\BackendServices\Services\CompanyService;

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('companyService', function()
        {
            return new CompanyService();
        });
    }
}
