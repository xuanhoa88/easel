@extends('canvas::backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Reset Password</title>
@stop

@section('login')
    <div class="login-container">
        @include('canvas::shared.errors')
        @include('canvas::auth.passwords.partials.reset-form')
    </div>
@endsection

@section('unique-js')
    {!! JsValidator::formRequest('Canvas\Http\Requests\PasswordResetRequest', '#forgot-password') !!}
    @include('canvas::backend.shared.components.show-password', ['inputs' => 'input[name="password"]'])
@stop