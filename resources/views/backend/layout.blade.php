<!DOCTYPE html>
<html lang="en">
    <head>
        @include('canvas::shared.meta-tags')
        @yield('title')
        @include('canvas::backend.partials.backend-css')
    </head>
    <body @if(Auth::check()) class="toggled sw-toggled" @endif>
        @if (Auth::guest())
            @yield('login')
        @else
            @include('canvas::backend.partials.header')
            @yield('content')
            @include('canvas::shared.page-loader')
            @include('canvas::backend.partials.footer')
        @endif
        @include('canvas::backend.partials.backend-js')
        @include('canvas::backend.partials.search-js')
        @yield('unique-js')
    </body>
</html>
