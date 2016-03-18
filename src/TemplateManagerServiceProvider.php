<?php namespace Corb\TemplateManager;

use Illuminate\Support\ServiceProvider;


class TemplateManagerServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/template-manager.php' => config_path('template-manager.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(TemplateManagerContract::class, function ($app) {
            return new TemplateManager(config('template-manager.models'));
        });

    }

    /*
    * Get the services provided by the provider.
    *
    * @return array
    */
    public function provides()
    {
        return [TemplateManagerContract::class];
    }
}
