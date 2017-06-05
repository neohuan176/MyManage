<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\BackendServices\Services\exportExcelService;

class exportExcelServiceProvider extends ServiceProvider
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
        $this->app->singleton('exportExcelService', function()
        {
            return new exportExcelService();
        });
    }
}
