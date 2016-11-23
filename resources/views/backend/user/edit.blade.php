@extends('canvas::backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Edit User</title>
@stop

@section('content')
    <section id="main">
        @include('canvas::backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container container-alt">
                <div class="block-header">
                    <h2>User Profile</h2>
                    <ul class="actions">
                        <li class="dropdown">
                            <a href="" data-toggle="dropdown">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="{{ url('admin/user/' . $data['id'] . '/edit') }}"><i class="zmdi zmdi-refresh-alt pd-r-5"></i> Refresh User</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="card" id="profile-main">
                    @include('canvas::backend.user.partials.sidebar')
                    <div class="pm-body clearfix">
                        <ul class="tab-nav tn-justified">
                            <li class="{{ Route::is('admin.user.edit') ? 'active' : '' }}">
                                <a href="{{ url('admin/user/' . $data['id'] . '/edit') }}">Profile</a>
                            </li>
                            <li class="{{ Route::is('admin.user.privacy') ? 'active' : '' }}">
                                <a href="{{ url('/admin/user/' . $data['id'] . '/privacy') }}">Privacy</a>
                            </li>
                        </ul>
                        @if(Session::has('errors') || Session::has('success'))
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    @include('canvas::shared.errors')
                                    @include('canvas::shared.success')
                                </div>
                            </div>
                        @endif
                        @include('canvas::backend.user.partials.form.edit')
                    </div>
                </div>
            </div>
        </section>
    </section>
    @include('canvas::backend.user.partials.modals.delete')
@stop

@section('unique-js')
    {!! JsValidator::formRequest('Canvas\Http\Requests\UserUpdateRequest', '#userUpdate') !!}
    @include('canvas::backend.shared.components.profile-datetime-picker', ['format' => 'YYYY-MM-DD'])

    @if(Session::get('_updateUser'))
        @include('canvas::backend.partials.notify', ['section' => '_updateUser'])
        {{ \Session::forget('_updateUser') }}
    @endif

    @if(Session::get('_updatePassword'))
        @include('canvas::backend.partials.notify', ['section' => '_updatePassword'])
        {{ \Session::forget('_updatePassword') }}
    @endif
@stop