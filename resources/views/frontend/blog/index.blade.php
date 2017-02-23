@extends('canvas::frontend.layout')

@section('title', \Canvas\Models\Settings::blogTitle().' | '.$tag->title or 'Blog')
@section('og-title', \Canvas\Models\Settings::blogTitle())
@section('twitter-title', \Canvas\Models\Settings::blogTitle())
@section('og-description', \Canvas\Models\Settings::blogDescription())
@section('twitter-description', \Canvas\Models\Settings::blogDescription())

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                @include('canvas::frontend.blog.partials.tag-head')
                @include('canvas::frontend.blog.partials.posts')
                @include('canvas::frontend.blog.partials.index-pager')
            </div>
        </div>
    </div>
@stop

@section('unique-js')
    <script src="{{ elixir('vendor/canvas/assets/js/frontend.js') }}" charset="utf-8"></script>
@endsection