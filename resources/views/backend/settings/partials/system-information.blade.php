<div class="card">
    <div class="card-header">
        <h2>System Information
            <small>To best assist you in any issues you encounter, please provide this information (ideally as a link to a <a href="https://gist.github.com/" target="_blank">Gist</a>) when requested by support staff.</small>
        </h2>
    </div>
    <div class="card-body card-padding">
        <pre>
            <code>
### Begin System Info ###

## Please include this information when requesting technical support ##

CANVAS_VERSION:             {{ $data['version'] }}

SITE_URL:                   {{ $data['url'] }}
SITE_IP:                    {{ $data['ip'] }}
SITE_TIMEZONE:              {{ $data['timezone'] }}

PHP_VERSION:                {{ $data['php_version'] }}
PHP_MEMORY_LIMIT:           {{ $data['php_memory_limit'] }}
PHP_TIME_LIMIT:             {{ $data['php_time_limit'] }}

DATABASE_CONNECTION:        {{ $data['db_connection'] }}

WEB_SERVER:                 {{ $data['web_server'] }}

LAST_INDEX_RUN:             {{ $data['last_index'] }}

### End System Info ###
            </code>
        </pre>
    </div>
</div>
