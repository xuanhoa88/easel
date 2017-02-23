<!DOCTYPE html>
<html lang="en">
    <head>
        @include('canvas::frontend.partials.meta')
        @include('canvas::frontend.partials.css')
        @include('canvas::frontend.partials.user-generated-css')
    </head>
    <body>
        @include('canvas::frontend.partials.header')
        @yield('content')
        @yield('unique-js')
        @include('canvas::frontend.partials.user-generated-js')
        @include('canvas::frontend.partials.footer')
    </body>
</html>
