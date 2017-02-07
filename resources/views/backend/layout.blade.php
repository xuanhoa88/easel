<!DOCTYPE html>
<html lang="en">
    <head>
        @include('canvas::shared.meta')
        @yield('title')
        @include('canvas::backend.partials.css')
    </head>
    <body @if(Auth::guard('canvas')->check()) class="toggled sw-toggled" @endif>
        @if (Auth::guard('canvas')->guest())
            @yield('login')
        @else
            @include('canvas::backend.partials.header')
            @yield('content')
            @include('canvas::shared.preloader')
            @include('canvas::backend.partials.footer')
        @endif
        @include('canvas::backend.partials.js')
        @include('canvas::backend.partials.search')
        @yield('unique-js')
    </body>
</html>
