<?php

namespace Canvas;

use Canvas\Models\Settings;
use Canvas\Console\Commands\Theme;
use Canvas\Console\Commands\Index;
use Canvas\Console\Commands\Update;
use Canvas\Console\Commands\Install;
use Canvas\Console\Commands\Version;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\ScoutServiceProvider;
use Canvas\Console\Commands\Publish\Views;
use Canvas\Console\Commands\Publish\Assets;
use Canvas\Console\Commands\Publish\Config;
use Maatwebsite\Excel\ExcelServiceProvider;
use Canvas\Console\Commands\Publish\Migrations;
use Canvas\Extensions\ExtensionsServiceProvider;
use TeamTNT\Scout\TNTSearchScoutServiceProvider;
use Larapack\ConfigWriter\Repository as ConfigWriter;
use Austintoddj\JsValidation\Facades\JsValidatorFacade;
use Austintoddj\JsValidation\JsValidationServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use TalvBansal\MediaManager\Providers\MediaManagerServiceProvider;

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
        Update::class,
        Config::class,
        Assets::class,
        Version::class,
        Views::class,
        Theme::class,
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
        $this->mergeConfigFrom($configPath, 'blog');
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
        // Load migrations...
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
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
        $this->app->register(JsValidationServiceProvider::class);
        $this->app->register(ScoutServiceProvider::class);
        $this->app->register(ExcelServiceProvider::class);
        $this->app->register(MediaManagerServiceProvider::class);
        $this->app->register(TNTSearchScoutServiceProvider::class);
        $this->app->register(ExtensionsServiceProvider::class);

        // Register Facades...
        $loader = AliasLoader::getInstance();
        $loader->alias('JsValidator', JsValidatorFacade::class);
        $loader->alias('ConfigWriter', ConfigWriter::class);
        $loader->alias('Excel', Excel::class);
        $loader->alias('Settings', Settings::class);
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