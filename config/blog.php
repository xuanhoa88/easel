<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Canvas Configuration : Blog Posts Per Page
    |--------------------------------------------------------------------------
    |
    | Pretty self-explanatory here. Indicate how many posts you would like
    | to appear on each page.
    |
    */
    'posts_per_page' => 6,

    /*
    |--------------------------------------------------------------------------
    | Canvas Configuration : Trim Width
    |--------------------------------------------------------------------------
    |
    | To make sure post subtitles and post excerpts display properly in
    | the application, we need to trim the width of them and simply
    | add an ellipses at the trim point.
    |
    | backend_trim_width: NOT CURRENTLY IN USE
    | frontend_trim_width: Used in the individual post view template
    |
    */
    'backend_trim_width' => 40,
    'frontend_trim_width' => 225,

    /*
    |--------------------------------------------------------------------------
    | Canvas Configuration : Post Layout
    |--------------------------------------------------------------------------
    |
    | The post layout is only specified in Canvas\Jobs\PostFormFields.php.
    | If you need to update the layout, just change it there.
    |
    */
    'post_layout' => Canvas\Jobs\PostFormFields::$blogLayout,

    /*
    |--------------------------------------------------------------------------
    | Canvas Configuration : Tag Layout
    |--------------------------------------------------------------------------
    |
    | The tag layout is specified here, in Canvas\Http\Controllers\Backend\TagController.php
    | and in Canvas\Models\Tag.php. If you need to update the layout, just change it
    | in these three locations.
    |
    */
    'tag_layout' => 'canvas::frontend.blog.index',
];
