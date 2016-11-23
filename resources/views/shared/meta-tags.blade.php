<meta charset="utf-8">

<!-- Facebook Open Graph Tags -->
<meta name="og:type" content="blog">
<meta name="og:site_name" content="{{ \Canvas\Models\Settings::blogTitle() }}">
@yield('og-title')
@yield('og-image')
@yield('og-description')

<!-- Twitter Cards -->
@if (Request::is('blog/*'))
    @yield('twitter-card')
@else
    <meta name="twitter:card" content="{{ \Canvas\Models\Settings::twitterCardType() }}" />
    <meta name="twitter:site" content="{{ $user->twitter or ''}}" />
    <meta name="twitter:title" content="{{ \Canvas\Models\Settings::blogTitle() }}" />
    <meta name="twitter:description" content="{{ \Canvas\Models\Settings::blogDescription() }}" />
    <meta name="twitter:image" content="{{ url('vendor/canvas/assets/images/favicon.png') }}" />
@endif

<!-- SEO Tags -->
<meta name="keywords" content="{{ \Canvas\Models\Settings::blogSeo() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="{{ \Canvas\Models\Settings::blogAuthor() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0 maximum-scale=1.0, user-scalable=no">
<meta name="description" content="{{ \Canvas\Models\Settings::blogDescription() }}">

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('vendor/canvas/assets/images/favicon.png') }}">