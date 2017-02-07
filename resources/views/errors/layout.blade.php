<!DOCTYPE html>
<html lang="en">
    <head>
        @include('canvas::shared.meta')
        @yield('title')
        @include('canvas::backend.partials.css')
    </head>
    <body>
        @yield('content')
        @yield('unique-js')
    </body>
</html>