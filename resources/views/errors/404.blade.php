@extends('canvas::errors.layout')

@section('title')
    <title>Canvas | Page not found</title>
@stop

@section('content')
    <div class="login-container">
        <p class="f-20 f-300 text-center">404 - Page Not Found</p>
        <p class="text-muted text-center">Sorry, but nothing exists here.</p>
        @if(Auth::check())
            <div style="text-align: center">
                <a href="{{ url('/admin') }}" class="btn btn-link m-t-10">Back to Dashboard</a>
            </div>
        @else
            <div style="text-align: center">
                <a href="{{ url('/') }}" class="btn btn-link m-t-10">Back to Blog</a>
            </div>
        @endif
    </div>
@stop
