<?php

namespace STORMSQ\Developer;

use Illuminate\Support\ServiceProvider;
use STORMSQ\Developer\Commands\GenerateService;
use STORMSQ\Developer\Commands\GeneratePresenter;
class DeveloperServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/developer.php' => config_path('developer.php'),
        ],'developer');
        $this->commands([
            GenerateService::class,
            GeneratePresenter::class,
        ]);
    
    }

    // 註冊套件函式
    public function register()
    {

        $this->app->singleton('ServiceBuilder', function ($app) {
            return new ServiceBuilder();
        });
    }
}