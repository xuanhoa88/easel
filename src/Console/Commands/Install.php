<?php

namespace Canvas\Console\Commands;

use Artisan;
use Exception;
use Canvas\Models\User;
use Canvas\Helpers\SetupHelper;
use Canvas\Helpers\ConfigHelper;
use Canvas\Extensions\ThemeManager;

class Install extends CanvasCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:install {--views : Also publish Canvas views.} {--f|force : Overwrite existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Canvas install wizard';

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
     * If the canvas_installed.lock file is found in the storage/ directory
     * the installer will not execute.
     *
     * @return mixed
     */
    public function handle()
    {
        if (file_exists(storage_path('canvas_installed.lock'))) {
            $this->line('<info>✔</info> Canvas has already been installed.');
        } else {
            $config = ConfigHelper::getWriter();

            // Gather the options...
            $force = $this->option('force') ?: false;
            $withViews = $this->option('views') ?: false;

            $this->comment(PHP_EOL.'Welcome to the Canvas Install Wizard! You\'ll be up and running in no time...');

            // Attempt to link storage/app/public folder to public/storage;
            // This won't work on an OS without symlink support (e.g. Windows)
            try {
                Artisan::call('storage:link');
            } catch (Exception $e) {
                $this->line(PHP_EOL.'Could not link <info>storage/app/public</info> folder to <info>public/storage</info>:');
                $this->line("<error>✘</error> {$e->getMessage()}");
            }

            try {
                // Publish config files...
                Artisan::call('canvas:publish:config', [
                    '--y' => true,
                    '--force' => true,
                ]);
                // Publish public assets...
                Artisan::call('canvas:publish:assets', [
                    '--y' => true,
                    '--force' => true,
                ]);
                // Publish view files...
                if ($withViews) {
                    Artisan::call('canvas:publish:views', [
                        '--y' => true,
                        '--force' => $force,
                    ]);
                }

                // Set up the database...
                if (! (SetupHelper::requiredTablesExists())) {
                    $this->comment(PHP_EOL.'Setting up your database...');
                    $exitCode = Artisan::call('migrate', []);
                    $exitCode = Artisan::call('db:seed', [
                        '--class' => 'Canvas\DatabaseSeeder',
                    ]);
                    $this->progress(5);
                    $this->line(PHP_EOL.'<info>✔</info> Success! Your database is set up and configured.');
                }

                $this->comment(PHP_EOL.'Please provide the following information. Don\'t worry, you can always change these settings later.');

                // Admin user information...
                $this->comment(PHP_EOL.'<info>Step 1/6: Creating the admin user account</info>');
                $email = $this->ask('Email');
                $password = $this->secret('Password');
                $firstName = $this->ask('First name');
                $lastName = $this->ask('Last name');
                $this->createUser($email, $password, $firstName, $lastName);
                $this->line(PHP_EOL.'<info>✔</info> Success! Your admin user account has been created.');

                // Blog title...
                $blogTitle = $this->ask('Step 2/6: Title of your blog');
                $this->title($blogTitle);
                $this->line(PHP_EOL.'<info>✔</info> Success! The title of the blog has been saved.');

                // Blog subtitle...
                $blogSubtitle = $this->ask('Step 3/6: Subtitle of your blog');
                $this->subtitle($blogSubtitle);
                $this->line(PHP_EOL.'<info>✔</info> Success! The subtitle of the blog has been saved.');

                // Blog description...
                $blogDescription = $this->ask('Step 4/6: Description of your blog');
                $this->description($blogDescription);
                $this->line(PHP_EOL.'<info>✔</info> Success! The description of the blog has been saved.');

                // Blog SEO tags...
                $blogSEO = $this->ask('Step 5/6: Blog SEO keywords (simple,powerful,blog,publishing,platform)');
                $this->seo($blogSEO);
                $this->line(PHP_EOL.'<info>✔</info> Success! The blog SEO keywords have been saved.');

                // Blog posts per page...
                $postsPerPage = $this->ask('Step 6/6: Number of posts to display per page');
                $this->postsPerPage($postsPerPage, $config);
                $this->line(PHP_EOL.'<info>✔</info> Success! The number of posts per page has been saved.');

                // Build the search index...
                $this->rebuildSearchIndexes();

                // Generate a unique application key...
                $this->comment(PHP_EOL.'Creating a unique application key...');
                $exitCode = Artisan::call('key:generate');
                $this->progress(5);
                $this->line(PHP_EOL.'<info>✔</info> Success! A unique application key has been generated.');

                // Additional blog settings...
                $this->comment(PHP_EOL.'Finishing the installation...');
                $this->disqus();
                $this->googleAnalytics();
                $this->twitterCardType();
                $this->canvasVersion();
                $this->installed();
                $this->socialHeaderIcons();
                $this->progress(5);

                // Clear the caches...
                Artisan::call('cache:clear');
                Artisan::call('view:clear');
                Artisan::call('route:clear');

                $this->line(PHP_EOL.'<info>✔</info> Canvas has been installed. Pretty easy huh?'.PHP_EOL);

                // Display installation info...
                $headers = ['Login Email', 'Login Password', 'Version', 'Theme'];
                $data = User::select('email', 'password')->get()->toArray();

                $themeManager = new ThemeManager(resolve('app'), resolve('files'));
                $activeTheme = $themeManager->getTheme($themeManager->getActiveTheme()) ?: $themeManager->getDefaultTheme();
                $data[0]['password'] = 'Your chosen password.';
                array_push($data[0], 'Canvas'.' '.$this->canvasVersion(), $activeTheme->getName().' '.$activeTheme->getVersion());
                $this->table($headers, $data);
                $this->line(PHP_EOL);

                $config->save();
            } catch (Exception $e) {
                // Rollback migrations
                // Artisan::call('migrate:rollback');
                // Remove install file
                $this->uninstalled();
                // Display message
                $this->line(PHP_EOL.'<error>An unexpected error occurred. Installation could not continue.</error>');
                $this->error("✘ {$e->getMessage()}");
                $this->comment(PHP_EOL.'Please run the installer again.');
                $this->line(PHP_EOL.'If this error persists please consult https://github.com/cnvs/easel/issues.'.PHP_EOL);
            }
        }
    }
}
