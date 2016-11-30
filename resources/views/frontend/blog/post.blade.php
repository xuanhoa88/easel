@extends('canvas::frontend.layout', [
  'title' => $post->title,
  'meta_description' => $post->meta_description ?: Settings::blogDescription(),
])

@section('og-title')
    <meta property="og:title" content="{{ $post->title }}"/>
@stop

@if ($post->page_image)
    @section('og-image')
        <meta property="og:image" content="{{ url( $post->page_image ) }}">
    @stop
@endif

@section('og-description')
    <meta property="og:description" content="{{ $post->meta_description }}"/>
@stop

@section('twitter-card')
    @if ($post->title != '')
        <meta name="twitter:title" content="{{ $post->title }}" />
    @endif
    @if ($post->meta_description != '')
        <meta name="twitter:description" content="{{ $post->meta_description }}" />
    @endif
    @if ($post->page_image != '')
        <meta name="twitter:image" content="{{ url('/uploads/' . $post->page_image) }}" />
    @endif
@stop

@section('title')
    <title>{{ $title or Settings::blogTitle() }}</title>
@stop

@section('unique-js')
    <script src="{{ elixir('vendor/canvas/assets/js/frontend.js') }}" charset="utf-8"></script>
@endsection

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