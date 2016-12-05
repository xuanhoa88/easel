<?php

namespace Canvas\Console\Commands;

use Artisan;

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
    protected $description = 'Create the initial search index';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createPostsIndex();
        $this->line('<info>✔</info> Success! The posts index has been created.');

        $this->createTagsIndex();
        $this->line('<info>✔</info> Success! The tags index has been created.');

        $this->createUsersIndex();
        $this->line('<info>✔</info> Success! The users index has been created.');
    }

    public function createPostsIndex()
    {
        $this->comment(PHP_EOL.'Indexing the posts table and saving it to /storage/posts.index...');
        Artisan::call('scout:import', ['model' => 'Canvas\\Models\\Post']);
    }

    public function createTagsIndex()
    {
        $this->comment(PHP_EOL.'Indexing the tags table and saving it to /storage/tags.index...');
        Artisan::call('scout:import', ['model' => 'Canvas\\Models\\Tag']);
    }

    public function createUsersIndex()
    {
        $this->comment(PHP_EOL.'Indexing the users table and saving it to /storage/users.index...');
        Artisan::call('scout:import', ['model' => 'Canvas\\Models\\User']);
    }
}
