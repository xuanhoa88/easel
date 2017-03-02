<?php

namespace Canvas\Console\Commands;

use Artisan;
use Exception;

class Index extends CanvasCommand
{
    protected $tnt;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index blog content for searches';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->createPostsIndex();
            $this->line('<info>✔</info> Success! The posts index has been created.');

            $this->createTagsIndex();
            $this->line('<info>✔</info> Success! The tags index has been created.');

            $this->createUsersIndex();
            $this->line('<info>✔</info> Success! The users index has been created.');
        } catch (Exception $e) {
            $this->line(PHP_EOL.'<error>✘</error> '.$e->getMessage());
        }
    }

    public function createPostsIndex()
    {
        $this->comment(PHP_EOL.'Indexing the posts table and saving it to /storage/canvas_posts.index...');
        Artisan::call('scout:import', ['model' => 'Canvas\\Models\\Post']);
    }

    public function createTagsIndex()
    {
        $this->comment(PHP_EOL.'Indexing the tags table and saving it to /storage/canvas_tags.index...');
        Artisan::call('scout:import', ['model' => 'Canvas\\Models\\Tag']);
    }

    public function createUsersIndex()
    {
        $this->comment(PHP_EOL.'Indexing the users table and saving it to /storage/canvas_users.index...');
        Artisan::call('scout:import', ['model' => 'Canvas\\Models\\User']);
    }
}
