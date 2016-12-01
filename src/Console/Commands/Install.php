<?php

namespace Canvas\Console\Commands;

use Artisan;
use ConfigWriter;
use Canvas\Models\User;
use Illuminate\Support\Facades\Validator;

class Install extends CanvasCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:install {--views : Also publish Canvas views.} {--f|force : Overwrite any existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure Canvas.';

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
        $config = new ConfigWriter('blog');

        // gather options
        $force = $this->option('force') ?: false;
        $withViews = $this->option('views') ?: false;

        // Welcome
        $this->comment(PHP_EOL.'Welcome to Canvas! You\'ll be up and running in no time...');

        // config
        Artisan::call('canvas:publish:config', [
            '--y' => true,
            '--force' => $force,
        ]);
        // database
        Artisan::call('canvas:publish:migrations', [
            '--y' => true,
            '--force' => $force,
        ]);
        // public
        Artisan::call('canvas:publish:assets', [
            '--y' => true,
            '--force' => $force,
        ]);
        // views
        if ($withViews) {
            Artisan::call('canvas:publish:views', [
                '--y' => true,
                '--force' => $force,
            ]);
        }

        $this->comment(PHP_EOL.'Please provide the following information. Don\'t worry, you can always change these settings later.');

        // Admin User
        $this->comment(PHP_EOL.'Step 1/6: Creating the admin user');
        $email = $this->ask('Admin email address');
        $rules = ['email' => 'unique:users,email'];
        $validator = Validator::make(['email' => $email], $rules);
        if ($validator->fails()) {
            $this->error('Sorry! That email already exists in the system.');
            $this->comment('Please run the installer again.');
            die();
        }
        $password = $this->ask('Admin password');
        $firstName = $this->ask('Admin first name');
        $lastName = $this->ask('Admin last name');
        $this->createUser($email, $password, $firstName, $lastName);
        $this->line(PHP_EOL.'<info>✔</info> Success! Admin user has been created.');

        // Blog Title
        $blogTitle = $this->ask('Step 2/6: Title of your blog');
        $this->title($blogTitle);
        $this->line(PHP_EOL.'<info>✔</info> Success! The title of the blog has been saved.');

        // Blog Subtitle
        $blogSubtitle = $this->ask('Step 3/6: Subtitle of your blog');
        $this->subtitle($blogSubtitle);
        $this->line(PHP_EOL.'<info>✔</info> Success! The subtitle of the blog has been saved.');

        // Blog Description
        $blogDescription = $this->ask('Step 4/6: Description of your blog');
        $this->description($blogDescription);
        $this->line(PHP_EOL.'<info>✔</info> Success! The description of the blog has been saved.');

        // Blog SEO
        $blogSEO = $this->ask('Step 5/6: Blog SEO keywords (simple,powerful,blog,publishing,platform)');
        $this->seo($blogSEO);
        $this->line(PHP_EOL.'<info>✔</info> Success! The blog SEO keywords have been saved.');

        // Posts Per Page
        $postsPerPage = $this->ask('Step 6/6: Number of posts to display per page');
        $this->postsPerPage($postsPerPage, $config);
        $this->line(PHP_EOL.'<info>✔</info> Success! The number of posts per page has been saved.');

        // Search Index
        $this->comment(PHP_EOL.'Building the search index...');
        if (file_exists(storage_path('posts.index'))) {
            unlink(storage_path('posts.index'));
        }
        if (file_exists(storage_path('users.index'))) {
            unlink(storage_path('users.index'));
        }
        if (file_exists(storage_path('tags.index'))) {
            unlink(storage_path('tags.index'));
        }
        $exitCode = Artisan::call('canvas:index');
        $this->progress(5);
        $this->line(PHP_EOL.'<info>✔</info> Success! The application search index has been built.');

        // Application Key Generation
        $this->comment(PHP_EOL.'Creating a unique application key...');
        $exitCode = Artisan::call('key:generate');
        $this->progress(5);
        $this->line(PHP_EOL.'<info>✔</info> Success! A unique application key has been generated.');

        // Additional Settings
        $this->comment(PHP_EOL.'Finishing up the installation...');
        $this->disqus();
        $this->googleAnalytics();
        $this->twitterCardType();
        $this->canvasVersion();
        $this->progress(5);

        $this->line(PHP_EOL.'<info>✔</info> Canvas has been installed. Pretty easy huh?'.PHP_EOL);

        $headers = ['Login Email', 'Login Password'];
        $data = User::select('email', 'password')->get()->toArray();
        $data[0]['password'] = 'Your chosen password.';
        $this->table($headers, $data);

        $config->save();
    }
}
