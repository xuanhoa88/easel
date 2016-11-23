<!DOCTYPE html>
<html lang="en">
    <head>
        @include('canvas::shared.meta-tags')
        @yield('title')
        @include('canvas::backend.partials.backend-css')
    </head>
    <body>
        @yield('content')
        @yield('unique-js')
    </body>
</html>