<?php

namespace Canvas;

use Canvas\Console\Commands\Index;
use Canvas\Console\Commands\Install;
use Illuminate\Support\ServiceProvider;
use Canvas\Console\Commands\Publish\Views;
use Canvas\Console\Commands\Publish\Assets;
use Canvas\Console\Commands\Publish\Config;
use Canvas\Console\Commands\Publish\Migrations;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class CanvasServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * List of commands.
     *
     * @var array
     */
    protected $commands = [
        Index::class,
        Install::class,
        Config::class,
        Migrations::class,
        Assets::class,
        Views::class,
    ];

    /**
     * Public asset files.
     */
    private function handleAssets()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/canvas'),
        ], 'public');
    }

    /**
     * Configuration files.
     */
    private function handleConfigs()
    {
        $configPath = __DIR__.'/../config/blog.php';

        // Allow publishing the config file, with tag: config
        $this->publishes([$configPath => config_path('blog.php')], 'config');

        // Merge config files
        // Allows any modifications from the published config file to be seamlessly merged with default config file
        $this->mergeConfigFrom($configPath, 'canvas');
    }

    /**
     * Translation files.
     */
    private function handleTranslations()
    {
        // Load translations
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'canvas');
    }

    /**
     * View files.
     */
    private function handleViews()
    {
        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'canvas');

        // Allow publishing view files, with tag: views
        $this->publishes([
            __DIR__.'/../resources/views/auth' => base_path('resources/views/vendor/canvas/auth'),
            __DIR__.'/../resources/views/backend' => base_path('resources/views/vendor/canvas/backend'),
            __DIR__.'/../resources/views/errors' => base_path('resources/views/vendor/canvas/errors'),
            __DIR__.'/../resources/views/frontend' => base_path('resources/views/vendor/canvas/frontend'),
            __DIR__.'/../resources/views/shared' => base_path('resources/views/vendor/canvas/shared'),
            __DIR__.'/../resources/views/vendor' => base_path('resources/views/vendor'),
        ], 'views');
    }

    /**
     * Migrations files.
     */
    private function handleMigrations()
    {
        // Allow publishing migration files, with tag: migrations
        $this->publishes([__DIR__.'/../database/migrations' => base_path('database/migrations')], 'migrations');
    }

    /**
     * Route files.
     */
    private function handleRoutes()
    {
        // Get the routes
        require realpath(__DIR__.'/../routes/web.php');
    }

    /**
     * Command files.
     */
    private function handleCommands()
    {
        // Register the commands
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register factory files.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->handleConfigs();
        $this->handleMigrations();
        $this->handleViews();
        $this->handleTranslations();
        $this->handleRoutes();
        $this->handleCommands();
        $this->handleAssets();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Bindings...
        $this->registerEloquentFactoriesFrom(__DIR__.'/../database/factories');

        // Register Service Providers...
        $this->app->register(\Austintoddj\JsValidation\JsValidationServiceProvider::class);
        $this->app->register(\Laravel\Scout\ScoutServiceProvider::class);
        $this->app->register(\Maatwebsite\Excel\ExcelServiceProvider::class);
        $this->app->register(\TalvBansal\MediaManager\Providers\MediaManagerServiceProvider::class);
        $this->app->register(\TeamTNT\Scout\TNTSearchScoutServiceProvider::class);

        // Register Facades...
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('JsValidator', \Austintoddj\JsValidation\Facades\JsValidatorFacade::class);
        $loader->alias('ConfigWriter', \Larapack\ConfigWriter\Repository::class);
        $loader->alias('Excel', \Maatwebsite\Excel\Facades\Excel::class);
        $loader->alias('Settings', \Canvas\Models\Settings::class);
        $loader->alias('Helpers', \Canvas\Helpers::class);
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
