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

@section('title', \Canvas\Models\Settings::blogTitle())

@section('content')
    <article>
        <div class="container" id="post">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    @if ($post->page_image)
                        <div class="text-center">
                            <img src="{{ asset($post->page_image) }}" class="post-hero">
                        </div>
                    @endif
                    <h1 class="post-page-title">{{ $post->title }}</h1>
                    <p class="post-page-meta">
                        {{ \Carbon\Carbon::parse($post->published_at)->diffForHumans() }} &#183; {{ $post->readingTime() }} MIN READ
                        @if ($post->tags->count())
                            <br>
                            {!! join(' ', $post->tagLinks()) !!}
                        @endif
                    </p>

                    {!! $post->content_html !!}

                    <p style="text-align: center"><span style="padding: 10px">&#183;</span><span style="padding: 10px">&#183;</span><span style="padding: 10px">&#183;</span></p>

                    @include('canvas::frontend.blog.partials.author')

                </div>
            </div>
        </div>
    </article>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <br>
                @include('canvas::frontend.blog.partials.post-pager')
            </div>
        </div>
    </div>
@stop

@section('unique-js')
    <script src="{{ elixir('vendor/canvas/assets/js/frontend.js') }}" charset="utf-8"></script>
@endsection