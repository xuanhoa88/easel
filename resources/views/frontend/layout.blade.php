<!DOCTYPE html>
<html lang="en">
    <head>
        @include('canvas::shared.meta-tags')
        @yield('title')
        <meta name="description" content="{{ $meta_description }}">
        @include('canvas::frontend.partials.css')
        @include('canvas::frontend.partials.custom-css')
    </head>
    <body>
        @include('canvas::frontend.partials.header')
        @yield('content')
        @yield('unique-js')
        @include('canvas::frontend.partials.custom-js')
        @include('canvas::frontend.partials.footer')
    </body>
</html>
