<?php

namespace Modules\Lawyer\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Lawyer\Entities\Lawyer;

class LawyerServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Lawyer', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Lawyer', 'Config/config.php') => config_path('lawyer.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Lawyer', 'Config/config.php'),
            'lawyer'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/lawyer');

        $sourcePath = module_path('Lawyer', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/lawyer';
        }, \Config::get('view.paths')), [$sourcePath]), 'lawyer');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/lawyer');

        $attributesPath = module_path('Lawyer', 'Resources/lang/' . app()->getLocale() . '/attributes.php');
        if (file_exists($attributesPath)) {
            setValidationAttributes(include $attributesPath);
        }

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'lawyer');
        } else {
            $this->loadTranslationsFrom(module_path('Lawyer', 'Resources/lang'), 'lawyer');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Lawyer', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
