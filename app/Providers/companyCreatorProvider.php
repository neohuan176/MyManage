<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\BackendServices\Creator\CompanyCreator;

class companyCreatorProvider extends ServiceProvider
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
        $this->app->bind('companyCreator', function()
        {
            return new CompanyCreator();
        });
    }
}
