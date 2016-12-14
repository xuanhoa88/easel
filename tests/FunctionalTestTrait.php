<?php

/**
 * Created by PhpStorm.
 * User: talv
 * Date: 14/12/16
 * Time: 00:56.
 */
trait FunctionalTestTrait
{

    /**
     * As we use laravel-elixirs "elixir" method in our views
     * PHP will squawk if the versioned files do not exist
     * within the expected directories, this trait will
     * publish assets to the expected location...
     */
    public function startFunctionalTestRequirements()
    {
        // Publish public assets
        $this->artisan('canvas:publish:assets', [
            '--y' => true,
            '--force' => true,
        ]);
    }
}