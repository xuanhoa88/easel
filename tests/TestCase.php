<?php

use Canvas\Models\Tag;
use Canvas\Models\Post;
use Canvas\Models\User;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    public function setUp()
    {
        parent::setUp();

        // Disable search indexing to increase unit test speed...
        Post::disableSearchSyncing();
        Tag::disableSearchSyncing();
        User::disableSearchSyncing();

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../database/migrations'),
        ]);

        $this->seed(\Canvas\TestDatabaseSeeder::class);
    }

    public function getEnvironmentSetUp($app)
    {
        $app['path.base'] = realpath(__DIR__.'/../src');

        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
            'strict'   => false,
        ]);

        // Set our custom user model...
        $app['config']->set('auth.providers.users.model', User::class);
    }

    /**
     * Load this packages service providers...
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Canvas\CanvasServiceProvider::class,
        ];
    }
}
