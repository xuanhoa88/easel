@extends('canvas::backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Forgot Password</title>
@stop

@section('login')
    <div class="login-container">
        @include('canvas::shared.errors')
        @include('canvas::auth.passwords.partials.email-form')
    </div>
@endsection

@section('unique-js')
    {!! JsValidator::formRequest('Canvas\Http\Requests\ForgotPasswordRequest', '#forgot-password') !!}
    @include('canvas::backend.shared.components.show-password', ['inputs' => 'input[name="password"]'])
@stop