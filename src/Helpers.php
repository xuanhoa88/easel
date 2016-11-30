<?php

namespace Canvas;

class Helpers
{
    // Roles
    const ROLE_USER = 0;
    const ROLE_ADMINISTRATOR = 1;

    // Maintenance Mode
    const MAINTENANCE_MODE_ENABLED = 0;
    const MAINTENANCE_MODE_DISABLED = 1;

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
     * Get the latest release of Canvas.
     * Since the GitHub API requires specific headers to be set, TravisCI will error
     * with a 403 Forbidden. As a workaround, we just return a hardcoded
     * string if the APP_ENV is set to testing.
     *
     * @return string
     */
    public static function getLatestRelease()
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
            $stream = file_get_contents('https://api.github.com/repos/cnvs/canvas/releases/latest', false, $context);
            $release = json_decode($stream);

            return $release->name;
        }
    }
}
