<?php

namespace Canvas\Console\Commands;

use Artisan;

class Update extends CanvasCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:update {--views : Also publish Canvas views.} {--f|force : Overwrite existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Canvas to the latest version';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the options passed into the command
        $force = $this->option('force') ?: false;
        $withViews = $this->option('views') ?: false;
        $update = true;

        // Grab version info
        $currentVersion = $oldVersion = $this->canvasVersion();
        $latestVersion = $this->latestVersion();

        // Display the welcome message
        $this->comment(PHP_EOL.'Welcome to the Canvas Update Wizard! You\'ll be back at it in no time...');

        if ($currentVersion != $latestVersion
            && $this->confirm(PHP_EOL."You are running Canvas core: $currentVersion. The latest version available is: $latestVersion.".PHP_EOL.'Update Canvas core?')) {
            // Update dependencies
            $this->comment(PHP_EOL.'Composer update...');
            $updateCore = shell_exec('cd '.base_path().'; composer update --quiet');
            $this->progress(5);
            $this->line(PHP_EOL.'<info>✔</info> Success! Canvas dependencies been updated.');
        }

        // Update core assets
        if ($update) {
            $this->comment(PHP_EOL.'Publishing core package assets...');

            // Don't link storage - assume storage is already linked
            // Don't publish config files - assume config has been set at install and modified afterwards

            // Publish public assets
            Artisan::call('canvas:publish:assets', [
                '--y' => true,
                // Always update public assets
                '--force' => true,
            ]);
            // Publish view files
            if ($withViews) {
                Artisan::call('canvas:publish:views', [
                    '--y' => true,
                    // User can decide this
                    '--force' => $force,
                ]);
            }
            $this->progress(5);
            $this->line(PHP_EOL.'<info>✔</info> Success! Canvas core assets have been published.');
        }

        $this->rebuildSearchIndexes();

        // Additional blog settings
        $this->comment(PHP_EOL.'Finishing the update...');

        // Clear all the caches
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        // Grab new version
        $newVersion = $this->canvasVersion();
        $this->progress(5);
        $this->line(PHP_EOL.'<info>✔</info> Canvas has been updated.'.PHP_EOL);

        // Display results
        $headers = ['Previous Version', 'New Version'];
        $data = [[$oldVersion, $newVersion]];
        $this->table($headers, $data);
        $this->line(PHP_EOL);
    }
}
