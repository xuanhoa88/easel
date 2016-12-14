@extends('canvas::backend.layout')

@section('title')
    <title>{{ \Settings::blogTitle() }} | Sign In</title>
@stop

@section('login')
    <div class="login-container">
        @include('canvas::shared.errors')
        @include('canvas::auth.partials.form')
    </div>
@endsection

@section('unique-js')
    {!! JsValidator::formRequest('Canvas\Http\Requests\LoginRequest', '#login') !!}
    @include('canvas::backend.shared.components.show-password', ['inputs' => 'input[name="password"]'])
@stop