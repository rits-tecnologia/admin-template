<?php

namespace Rits\AdminTemplate\Providers;

use Illuminate\Support\ServiceProvider;

class AdminTemplateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootPackage();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('breadcrumbs', function () {
            return (new Breadcrumbs)->setAttribute('class', 'breadcrumb');
        });
    }

    /**
     * Boot package vendor files.
     *
     * @return void
     */
    protected function bootPackage()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'admin-template');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'admin-template');

        $this->publishes([
            __DIR__ . '/../../resources/assets' => resource_path('assets/vendor/admin-template'),
        ], 'admin-template-assets');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/admin-template'),
        ], 'admin-template-views');

        $this->publishes([
            __DIR__ . '/../../config/admin-template.php' => config_path('admin-template.php'),
        ], 'admin-template-config');

        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/admin-template'),
        ], 'admin-template-trans');
    }
}
