<?php

namespace Canvas\Console\Commands;

use Illuminate\Console\Command;

class Index extends Command
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
    protected $description = 'Build the site index for searching';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createPostsIndex();
        $this->line('<info>✔</info> Success! The posts index has been completed.');

        $this->createTagsIndex();
        $this->line('<info>✔</info> Success! The tags index has been completed.');

        $this->createUsersIndex();
        $this->line('<info>✔</info> Success! The users index has been completed.');
    }

    public function createPostsIndex()
    {
        $this->comment(PHP_EOL.'Indexing posts table and saving it to /storage/posts.index...');
        \Artisan::call('scout:import', ['model' => 'Canvas\\Models\\Post']);
    }

    public function createTagsIndex()
    {
        $this->comment(PHP_EOL.'Indexing tags table and saving it to /storage/tags.index...');
        \Artisan::call('scout:import', ['model' => 'Canvas\\Models\\Tag']);
    }

    public function createUsersIndex()
    {
        $this->comment(PHP_EOL.'Indexing users table and saving it to /storage/users.index...');
        \Artisan::call('scout:import', ['model' => 'Canvas\\Models\\User']);
    }
}
