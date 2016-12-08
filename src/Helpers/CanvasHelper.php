<?php

namespace Canvas\Helpers;

use Session;
use Canvas\Models\User;
use Canvas\Models\Settings;
use Illuminate\Http\Request;

class CanvasHelper
{
    // Roles
    const ROLE_USER = 0;
    const ROLE_ADMINISTRATOR = 1;

    // Maintenance Mode
    const MAINTENANCE_MODE_ENABLED = 0;
    const MAINTENANCE_MODE_DISABLED = 1;

    // Core Info
    const CORE_PACKAGE = 'cnvs/easel';

    /**
     * Return 'checked' if true.
     *
     * @param $value
     * @return string
     */
    public static function checked($value)
    {
        return $value ? 'checked' : '';
    }

    /**
     * Actions to be taken when user is successfully authenticated.
     *
     * @param Illuminate\Http\Request $request
     * @param Canvas\Models\User $user
     * @return void
     */
    public static function authenticated(Request $request, User $user)
    {
        // Get and record latest version
        self::getLatestVersion();

        // Set login message
        Session::set('_login', trans('messages.login', ['display_name' => $user->display_name]));
    }

    /**
     * Get the latest release of Canvas.
     * Since the GitHub API requires specific headers to be set, TravisCI will error
     * with a 403 Forbidden. As a workaround, we just return a hardcoded
     * string if the APP_ENV is set to testing.
     *
     * @param bool $update If set to true, latest version in DB will be updated.
     * @return string
     */
    public static function getLatestVersion($update = true)
    {
        if (env('APP_ENV') === 'testing') {
            return 'v0.0.0';
        } else {
            $opts = [
                'http' => [
                    'method' => 'GET',
                    'header' => [
                        'User-Agent: PHP',
                    ],
                ],
            ];
            $context = stream_context_create($opts);
            $stream = file_get_contents('https://api.github.com/repos/cnvs/easel/releases/latest', false, $context);
            $release = json_decode($stream);

            // Save to the database
            if ($update) {
                $setting = Settings::updateOrCreate(
                    ['setting_name' => 'latest_release'],
                    ['setting_value' => $release->name]
                );
            }

            return $release->name;
        }
    }

    public static function getLatestRelease()
    {
        return self::getLatestVersion();
    }

    /**
     * Get the currently installed version of Canvas.
     *
     * @param bool $update If set to true, latest version in DB will be updated.
     * @return string
     */
    public static function getCurrentVersion($update = true)
    {
        $packageName = self::CORE_PACKAGE;
        $version = 'Unknown';

        // Retrieve core (Easel) package info from composer
        $info = shell_exec('cd '.base_path()."; composer show | grep $packageName");
        if ($info) {
            list($packageName, $version, $extra) = array_map('trim', preg_split("/\s+/", $info));
            if (substr($version, 0, 4) === 'dev-') {
                $version = "$version $extra";
            }
        }

        // Save to the database
        if ($update) {
            $setting = Settings::updateOrCreate(
                ['setting_name' => 'canvas_version'],
                ['setting_value' => $version]
            );
        }

        return $version;
    }

    public static function getInstalledVersion()
    {
        return self::getCurrentVersion();
    }

    public static function getCurrentRelease()
    {
        return self::getCurrentVersion();
    }
}
