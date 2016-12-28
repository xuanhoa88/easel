<?php

use Canvas\Helpers\RouteHelper;

// Canvas Application Routes : Frontend
Route::group([
    'middlewareGroups' => RouteHelper::getGeneralMiddlewareGroups(),
    'middleware' => RouteHelper::getGeneralMiddleware(),
    'prefix' => RouteHelper::getBlogMain(),
], function () {
    Route::get('install', 'Canvas\Http\Controllers\Setup\InstallController@index')->name('canvas.install');

    // Canvas Application Routes : Fully Installed and Configured
    Route::group([
        'middleware' => RouteHelper::getInstalledMiddleware(),
    ], function () {
        Route::get('/', 'Canvas\Http\Controllers\Frontend\BlogController@index')->name('home');

        Route::group(['prefix' => RouteHelper::getBlogPrefix()], function () {
            Route::get('/', 'Canvas\Http\Controllers\Frontend\BlogController@index')->name('blog.post.index');
            Route::get('post/{slug}', 'Canvas\Http\Controllers\Frontend\BlogController@showPost')->name('blog.post.show');
        });

        // Canvas Application Routes : Authentication
        Route::group([
            'namespace' => 'Canvas\Http\Controllers\Auth',
            'prefix' => RouteHelper::getAuthPrefix(),
        ], function () {
            Route::get('login', 'LoginController@showLoginForm')->name('login');
            Route::post('login', 'LoginController@login')->name('auth.login.store');
            Route::get('logout', 'LoginController@logout')->name('auth.logout');
            Route::post('password', 'PasswordController@updatePassword');

            Route::group(['prefix' => 'password'], function () {
                Route::get('forgot', 'ForgotPasswordController@showLinkRequestForm')->name('auth.password.forgot');
                Route::post('forgot', 'ForgotPasswordController@sendResetLinkEmail')->name('auth.password.forgot.store');
                Route::get('reset/{token}', 'ResetPasswordController@showResetForm')->name('auth.password.reset');
                Route::post('reset', 'ResetPasswordController@reset')->name('auth.password.reset.store');
            });
        });
    });
});

// Canvas Application Routes : Backend
Route::group([
    'middlewareGroups' => RouteHelper::getGeneralMiddlewareGroups(),
    'middleware' => RouteHelper::getAdminMiddleware(),
    'namespace' => 'Canvas\Http\Controllers\Backend',
], function () {
    Route::get(RouteHelper::getAdminPrefix(), 'HomeController@index')->name('admin');

    Route::resource(RouteHelper::getAdminPrefix().'/post', 'PostController', [
        'except' => 'show',
        'names' => [
            'index' => 'admin.post.index',
            'create' => 'admin.post.create',
            'store' => 'admin.post.store',
            'edit' => 'admin.post.edit',
            'update' => 'admin.post.update',
            'destroy' => 'admin.post.destroy',
        ],
    ]);

    Route::resource(RouteHelper::getAdminPrefix().'/tag', 'TagController', [
        'except' => 'show',
        'names' => [
            'index' => 'admin.tag.index',
            'create' => 'admin.tag.create',
            'store' => 'admin.tag.store',
            'edit' => 'admin.tag.edit',
            'update' => 'admin.tag.update',
            'destroy' => 'admin.tag.destroy',
        ],
    ]);

    Route::get(RouteHelper::getAdminPrefix().'/upload', 'UploadController@index')->name('admin.upload');

    \TalvBansal\MediaManager\Routes\MediaRoutes::get();

    Route::get(RouteHelper::getAdminPrefix().'/profile/privacy', 'ProfileController@editPrivacy')->name('admin.profile.privacy');
    Route::resource('admin/profile', 'ProfileController', [
        'only' => ['index', 'update'],
        'names' => [
            'index' => 'admin.profile.index',
            'update' => 'admin.profile.update',
        ],
    ]);

    Route::resource(RouteHelper::getAdminPrefix().'/search', 'SearchController', [
        'only' => ['index'],
        'names' => [
            'index' => 'admin.search.index',
        ],
    ]);

    Route::get(RouteHelper::getAdminPrefix().'/help', 'HelpController@index')->name('admin.help');

    // Routes only accessible if the user is an Administrator
    Route::group(['middleware' => 'checkIfAdmin'], function () {
        Route::resource(RouteHelper::getAdminPrefix().'/user', 'UserController', [
            'except' => 'show',
            'names' => [
                'index' => 'admin.user.index',
                'create' => 'admin.user.create',
                'store' => 'admin.user.store',
                'edit' => 'admin.user.edit',
                'update' => 'admin.user.update',
                'destroy' => 'admin.user.destroy',
            ],
        ]);
        Route::get(RouteHelper::getAdminPrefix().'/user/{id}/privacy', 'UserController@privacy')->name('admin.user.privacy');
        Route::post(RouteHelper::getAdminPrefix().'/user/{id}/privacy', 'UserController@updatePassword');

        Route::get(RouteHelper::getAdminPrefix().'/tools', 'ToolsController@index')->name('admin.tools');
        Route::post(RouteHelper::getAdminPrefix().'/tools/reset_index', 'ToolsController@resetIndex')->name('admin.tools.reset_index');
        Route::post(RouteHelper::getAdminPrefix().'/tools/cache_clear', 'ToolsController@clearCache')->name('admin.tools.cache_clear');
        Route::post(RouteHelper::getAdminPrefix().'/tools/download_archive', 'ToolsController@handleDownload')->name('admin.tools.download_archive');
        Route::post(RouteHelper::getAdminPrefix().'/tools/enable_maintenance_mode', 'ToolsController@enableMaintenanceMode')->name('admin.tools.enable_maintenance_mode');
        Route::post(RouteHelper::getAdminPrefix().'/tools/disable_maintenance_mode', 'ToolsController@disableMaintenanceMode')->name('admin.tools.disable_maintenance_mode');
        Route::get(RouteHelper::getAdminPrefix().'/settings', 'SettingsController@index')->name('admin.settings');
        Route::post(RouteHelper::getAdminPrefix().'/settings', 'SettingsController@store')->name('admin.settings');
    });
});
