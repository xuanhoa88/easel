@extends('canvas::frontend.layout')

@section('title')
    <title>{{ $tag->title or Settings::blogTitle() }} | Blog</title>
@stop

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