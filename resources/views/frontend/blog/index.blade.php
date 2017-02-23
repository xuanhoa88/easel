@extends('canvas::frontend.layout')

@section('og-title', $post->title)
@section('og-description', $post->meta_description)
@if ($post->page_image)
    @section('og-image', url( $post->page_image ))
@endif

@section('twitter-title', $post->title)
@section('twitter-description', $post->meta_description)
@if ($post->page_image)
    @section('twitter-image', url( $post->page_image ))
@endif

@section('title', Settings::blogTitle())

@section('unique-js')
    <script src="{{ elixir('vendor/canvas/assets/js/frontend.js') }}" charset="utf-8"></script>
@endsection

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