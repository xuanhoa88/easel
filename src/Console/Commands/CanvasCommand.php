<?php

namespace Canvas\Console\Commands;

use Canvas\Helpers;
use Canvas\Models\User;
use Canvas\Models\Settings;
use Illuminate\Console\Command;

class CanvasCommand extends Command
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function progress($tasks)
    {
        $bar = $this->output->createProgressBar($tasks);

        for ($i = 0; $i < $tasks; $i++) {
            time_nanosleep(0, 200000000);
            $bar->advance();
        }

        $bar->finish();
    }

    protected function title($blogTitle)
    {
        $settings = new Settings();
        $settings->setting_name = 'blog_title';
        $settings->setting_value = $blogTitle;
        $settings->save();
        $this->comment('Saving blog title...');
        $this->progress(1);
    }

    protected function subtitle($blogSubtitle)
    {
        $settings = new Settings();
        $settings->setting_name = 'blog_subtitle';
        $settings->setting_value = $blogSubtitle;
        $settings->save();
        $this->comment('Saving blog subtitle...');
        $this->progress(1);
    }

    protected function description($blogDescription)
    {
        $settings = new Settings();
        $settings->setting_name = 'blog_description';
        $settings->setting_value = $blogDescription;
        $settings->save();
        $this->comment('Saving blog description...');
        $this->progress(1);
    }

    protected function seo($blogSeo)
    {
        $settings = new Settings();
        $settings->setting_name = 'blog_seo';
        $settings->setting_value = $blogSeo;
        $settings->save();
        $this->comment('Saving blog SEO keywords...');
        $this->progress(1);
    }

    protected function postsPerPage($postsPerPage, $config)
    {
        $config->set('posts_per_page', intval($postsPerPage));
        $this->comment('Saving posts per page...');
        $this->progress(1);
    }

    protected function disqus()
    {
        $settings = new Settings();
        $settings->setting_name = 'disqus_name';
        $settings->setting_value = null;
        $settings->save();
    }

    protected function googleAnalytics()
    {
        $settings = new Settings();
        $settings->setting_name = 'ga_id';
        $settings->setting_value = null;
        $settings->save();
    }

    protected function twitterCardType()
    {
        $settings = new Settings();
        $settings->setting_name = 'twitter_card_type';
        $settings->setting_value = 'none';
        $settings->save();
    }

    protected function canvasVersion()
    {
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: PHP',
                ],
            ],
        ];
        $context = stream_context_create($opts);
        $stream = file_get_contents('https://api.github.com/repos/cnvs/canvas/releases/latest', false, $context);
        $release = json_decode($stream);

        $settings = new Settings();
        $settings->setting_name = 'canvas_version';
        $settings->setting_value = $release->name;
        $settings->save();
    }

    protected function createUser($email, $password, $firstName, $lastName)
    {
        $user = new User();
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->display_name = $firstName.' '.$lastName;
        $user->role = Helpers::ROLE_ADMINISTRATOR;
        $user->save();

        $this->author($user->display_name);
        $this->comment('Saving admin information...');
        $this->progress(1);
    }

    protected function author($blogAuthor)
    {
        $settings = new Settings();
        $settings->setting_name = 'blog_author';
        $settings->setting_value = $blogAuthor;
        $settings->save();
    }
}
