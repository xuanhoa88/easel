<?php

namespace Canvas;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;
use Canvas\Console\Commands\Index;
use Canvas\Console\Commands\Install;

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
    ];

    /**
     * Public assets.
     */
    private function handleAssets()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/canvas'),
        ], 'public');
    }

    /**
     * Config.
     */
    private function handleConfigs()
    {
        $configPath = __DIR__.'/../config/canvas.php';

        // allow publishing config, with tag: config
        $this->publishes([$configPath => config_path('blog.php')], 'config');

        // merge config;
        // allowing any modifications from published config file to be seemlessly merged with default config
        $this->mergeConfigFrom($configPath, 'canvas');
    }

    /**
     * Translations.
     */
    private function handleTranslations()
    {
        // load translations
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'canvas');
    }

    /**
     * Views.
     */
    private function handleViews()
    {
        // load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'canvas');

        // allow publishing views, with tag: views
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
     * Migrations.
     */
    private function handleMigrations()
    {
        // allow publishing migrations, with tag: migrations
        $this->publishes([__DIR__.'/../database/migrations' => base_path('database/migrations')], 'migrations');
    }

    /**
     * Routes.
     */
    private function handleRoutes()
    {
        // get the routes
        require_once __DIR__.'/../routes/web.php';
    }

    /**
     * Commands.
     */
    private function handleCommands()
    {
        // register commands
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register factories.
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
