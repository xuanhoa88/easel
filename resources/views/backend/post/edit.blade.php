@extends('canvas::backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Edit Post</title>
@stop

@section('content')
    <section id="main">
        @include('canvas::backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                @include('canvas::backend.post.partials.form')
            </div>
        </section>
    </section>
    @include('canvas::backend.post.partials.modals.delete')
@stop

@section('unique-js')
    @include('canvas::backend.post.partials.editor')
    @include('canvas::backend.shared.components.datetime-picker')
    {!! JsValidator::formRequest('Canvas\Http\Requests\PostUpdateRequest', '#postUpdate'); !!}
    @if(Session::get('_update-post'))
        @include('canvas::backend.partials.notify', ['section' => '_update-post'])
        {{ \Session::forget('_update-post') }}
    @endif
    @if(Session::get('_new-post'))
        @include('canvas::backend.partials.notify', ['section' => '_new-post'])
        {{ \Session::forget('_new-post') }}
    @endif
@stop
