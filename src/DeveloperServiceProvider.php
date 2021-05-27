<?php

namespace STORMSQ\Developer;

use Illuminate\Support\ServiceProvider;
use STORMSQ\Developer\Commands\GenerateService;
use STORMSQ\Developer\Commands\GeneratePresenter;
use File;
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