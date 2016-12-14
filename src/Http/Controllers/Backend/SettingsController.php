<?php

namespace Canvas\Http\Controllers\Backend;

use Session;
use Canvas\Models\Settings;
use Canvas\Http\Controllers\Controller;
use Canvas\Http\Requests\SettingsUpdateRequest;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'blogTitle' => Settings::blogTitle(),
            'blogSubtitle' => Settings::blogSubTitle(),
            'blogDescription' => Settings::blogDescription(),
            'blogSeo' => Settings::blogSeo(),
            'blogAuthor' => Settings::blogAuthor(),
            'disqus' => Settings::disqus(),
            'analytics' => Settings::gaId(),
            'twitterCardType' => Settings::twitterCardType(),
            'url' => $_SERVER['HTTP_HOST'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'timezone' => env('APP_TIMEZONE'),
            'php_version' => phpversion(),
            'php_memory_limit' => ini_get('memory_limit'),
            'php_time_limit' => ini_get('max_execution_time'),
            'db_connection' => strtoupper(env('DB_CONNECTION')),
            'web_server' => $_SERVER['SERVER_SOFTWARE'],
            'last_index' => date('Y-m-d H:i:s', file_exists(storage_path('posts.index')) ? filemtime(storage_path('posts.index')) : false),
            'version' => (! empty(Settings::canvasVersion())) ? Settings::canvasVersion() : 'Less than or equal to v2.1.7',
        ];

        return view('canvas::backend.settings.index', compact('data'));
    }

    /**
     * Store the site configuration options. This is currently accomplished
     * by finding the specific option, deleting it, and then inserting
     * the new option.
     *
     * @param SettingsUpdateRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function store(SettingsUpdateRequest $request)
    {
        Settings::updateOrCreate(['setting_name' => 'blog_title'], ['setting_value' => $request->toArray()['blog_title']]);
        Settings::updateOrCreate(['setting_name' => 'blog_subtitle'], ['setting_value' => $request->toArray()['blog_subtitle']]);
        Settings::updateOrCreate(['setting_name' => 'blog_description'], ['setting_value' => $request->toArray()['blog_description']]);
        Settings::updateOrCreate(['setting_name' => 'blog_seo'], ['setting_value' => $request->toArray()['blog_seo']]);
        Settings::updateOrCreate(['setting_name' => 'blog_author'], ['setting_value' => $request->toArray()['blog_author']]);
        Settings::updateOrCreate(['setting_name' => 'disqus_name'], ['setting_value' => $request->toArray()['disqus_name']]);
        Settings::updateOrCreate(['setting_name' => 'ga_id'], ['setting_value' => $request->toArray()['ga_id']]);
        Settings::updateOrCreate(['setting_name' => 'twitter_card_type'], ['setting_value' => $request->toArray()['twitter_card_type']]);

        Session::set('_update-settings', trans('messages.save_settings_success'));

        return redirect('admin/settings');
    }
}
