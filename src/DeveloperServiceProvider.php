<?php

namespace STORMSQ\DeveloperService;

use Illuminate\Support\ServiceProvider;
use STORMSQ\DeveloperService\Commands\GenerateService;
use File;
class DeveloperServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/developer-service.php' => config_path('developer-service.php'),
        ],'developer-service');
        $this->commands([
            GenerateService::class,
        ]);
        if (File::exists(__DIR__ . '/../helper/helpers.php')) {
            require __DIR__ . '/../helper/helpers.php';
        }
    
    }

    // 註冊套件函式
    public function register()
    {

        $this->app->singleton('ServiceBuilder', function ($app) {
            return new ServiceBuilder();
        });
    }
}