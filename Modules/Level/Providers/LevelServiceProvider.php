<?php

namespace Modules\Level\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class LevelServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('Level', 'Database/Migrations'));
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
            module_path('Level', 'Config/config.php') => config_path('level.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Level', 'Config/config.php'),
            'level'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/level');

        $sourcePath = module_path('Level', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/level';
        }, \Config::get('view.paths')), [$sourcePath]), 'level');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/level');
        $attributesPath = module_path('Level', 'Resources/lang/'.app()->getLocale().'/attributes.php');
        if (file_exists($attributesPath)) {
            setValidationAttributes(include $attributesPath);
        }

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'level');
        } else {
            $this->loadTranslationsFrom(module_path('Level', 'Resources/lang'), 'level');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Level', 'Database/factories'));
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
