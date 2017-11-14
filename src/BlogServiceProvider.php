<?php

namespace Bantenprov\VueBlog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Collective\Html\HtmlServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if(!$this->app->routesAreCached()){
            $this->app->router->group(
                [
                    'namespace' => 'Bantenprov\VueBlog\Controllers',
                    'prefix' => config('package.routing.prefix'),
                    // 'middleware' => config('package.routing.middleware')
                ]
                , function ()
            {
                require_once 'routes.php';
            });
        }

        //$this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'view');


        $this->app->register(HtmlServiceProvider::class);
        AliasLoader::getInstance(['Form'=>'\Collective\Html\FormFacade']);
        $this->viewHandle();
        $this->migrationHandle();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function viewHandle()
    {
        $packageViewsPath = __DIR__.'/resources/assets/js/components';
        $this->publishes([
            $packageViewsPath => resource_path('assets/js/components'),
        ], 'vue_assets');
    }

    protected function migrationHandle()
    {
        $packageMigrationsPath = __DIR__.'/migrations';
        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], 'vue_migrations');
    }
}
