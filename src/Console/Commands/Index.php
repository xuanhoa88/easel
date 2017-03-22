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
    protected $description = 'Index content for searches';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $time_start = microtime(true);
            $this->createPostsIndex();
            $this->createTagsIndex();
            $this->createUsersIndex();
            $time_end = microtime(true);
            $result = $time_end - $time_start;
            $this->line(PHP_EOL.'<info>[✔]</info> The index completed in '.round($result, 2).' '.str_plural('seconds.').PHP_EOL);
        } catch (Exception $e) {
            $this->line(PHP_EOL.'<error>[✘]</error> '.$e->getMessage());
        }
    }

    public function createPostsIndex()
    {
        $this->comment(PHP_EOL.'Indexing the posts table, saving to /storage/canvas_posts.index...');
        Artisan::call('scout:import', ['model' => 'Canvas\\Models\\Post']);
    }

    public function createTagsIndex()
    {
        $this->comment('Indexing the tags table, saving to /storage/canvas_tags.index...');
        Artisan::call('scout:import', ['model' => 'Canvas\\Models\\Tag']);
    }

    public function createUsersIndex()
    {
        $this->comment('Indexing the users table, saving to /storage/canvas_users.index...');
        Artisan::call('scout:import', ['model' => 'Canvas\\Models\\User']);
    }
}
