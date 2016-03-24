<?php

namespace Corb\TemplateManager;

use Illuminate\Support\ServiceProvider;

/**
 * Class TemplateManagerServiceProvider
 * @package Corb\TemplateManager
 * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
 */
class TemplateManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__.'/config/template-manager.php' => config_path('template-manager.php')
        ],'config');
        $file_prefix = date('Y_m_d_His_');
        $this->publishes([
            __DIR__.'/migrations/corb_template_manager_migration.php' => database_path('migrations/'.$file_prefix.'corb_template_manager_migration.php')
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @return void
     */
    public function register()
    {
        if(config('template-manager.use_routes') === true)
        {
            include __DIR__ . '/routes.php';
            $this->app->make( 'Corb\TemplateManager\TemplateManagerController' );
        }

    }
}
