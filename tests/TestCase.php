<?php

use Canvas\Models\Post;
use Canvas\Models\Tag;
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

        $this->setUpExtraTraits();

        #$this->seed(\Canvas\TestDatabaseSeeder::class);
    }

    public function getEnvironmentSetUp($app)
    {
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
        return [\Canvas\CanvasServiceProvider::class];
    }


    private function setUpExtraTraits()
    {
        $uses = array_flip(class_uses_recursive(static::class));

        if (isset($uses[FunctionalTestTrait::class])) {
            $this->startFunctionalTestRequirements();
        }
    }
}
