<?php

/*
|--------------------------------------------------------------------------
| Canvas Application Routes : Frontend
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'Canvas\Http\Controllers\Frontend\BlogController@index')->name('home');

    Route::group(['prefix' => 'blog'], function () {
        Route::get('/', 'Canvas\Http\Controllers\Frontend\BlogController@index')->name('blog.post.index');
        Route::get('{slug}', 'Canvas\Http\Controllers\Frontend\BlogController@showPost')->name('blog.post.show');
    });

    /*
    |--------------------------------------------------------------------------
    | Canvas Application Routes : Backend
    |--------------------------------------------------------------------------
    */
    Route::group([
        'namespace' => 'Canvas\Http\Controllers\Backend',
        'middleware' => 'auth',
    ], function () {
        Route::get('admin', 'HomeController@index');

        Route::resource('admin/post', 'PostController', [
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

        Route::resource('admin/tag', 'TagController', [
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

        Route::get('admin/upload', 'UploadController@index')->name('admin/upload');

        \TalvBansal\MediaManager\Routes\MediaRoutes::get();

        Route::get('admin/profile/privacy', 'ProfileController@editPrivacy')->name('admin.profile.privacy');
        Route::resource('admin/profile', 'ProfileController', [
            'only' => ['index', 'update'],
            'names' => [
                'index' => 'admin.profile.index',
                'update' => 'admin.profile.update',
            ],
        ]);

        Route::resource('admin/search', 'SearchController', [
            'only' => ['index'],
            'names' => [
                'index' => 'admin.search.index',
            ],
        ]);

        Route::get('admin/help', 'HelpController@index');

        // Routes only accessible if the user is an Administrator.
        Route::group(['middleware' => 'checkIfAdmin'], function () {
            Route::resource('admin/user', 'UserController', [
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
            Route::get('admin/user/{id}/privacy', 'UserController@privacy')->name('admin.user.privacy');
            Route::post('admin/user/{id}/privacy', 'UserController@updatePassword');

            Route::get('admin/tools', 'ToolsController@index');
            Route::post('admin/tools/reset_index', 'ToolsController@resetIndex');
            Route::post('admin/tools/cache_clear', 'ToolsController@clearCache');
            Route::post('admin/tools/download_archive', 'ToolsController@handleDownload');
            Route::post('admin/tools/enable_maintenance_mode', 'ToolsController@enableMaintenanceMode');
            Route::post('admin/tools/disable_maintenance_mode', 'ToolsController@disableMaintenanceMode');
            Route::get('admin/settings', 'SettingsController@index');
            Route::post('admin/settings', 'SettingsController@store');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Canvas Application Routes : Authentication
    |--------------------------------------------------------------------------
    */
    Route::group([
        'namespace' => 'Canvas\Http\Controllers\Auth',
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
