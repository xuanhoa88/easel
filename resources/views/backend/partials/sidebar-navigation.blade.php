<aside id="sidebar" class="sidebar c-overflow">
    <div class="profile-menu">
        <a href="">
            <div class="profile-pic">
                <img src="//www.gravatar.com/avatar/{!! md5(Auth::user()->email) !!}?d=identicon">
            </div>
            <div class="profile-info">
                {{ Auth::user()->display_name }}
                <i class="zmdi zmdi-caret-down"></i>
            </div>
        </a>
        <ul class="main-menu profile-ul">
            <li @if (Route::is('admin.profile.index')) class="active" @endif><a href="{!! route('admin.profile.index') !!}"><i class="zmdi zmdi-account"></i> Your Profile</a></li>
            <li><a href="{!! route('auth.logout') !!}" name="logout"><i class="zmdi zmdi-power"></i> Sign out</a></li>
        </ul>
    </div>
    <ul class="main-menu main-ul">
        <li @if (Route::is('admin')) class="active" @endif><a href="{!! route('admin') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="sub-menu @if (Request::is(CanvasRoute::routePath('admin.post.index').'*'))active toggled @endif">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-collection-bookmark"></i> Posts</a>
            <ul>
                <li><a href="{!! route('admin.post.index') !!}" @if (Route::is('admin.post.index')) class="active" @endif>All Posts <span class="label label-default label-totals">{!! Canvas\Models\Post::count() !!}</span></a></li>
                <li><a href="{!! route('admin.post.create') !!}" @if (Route::is('admin.post.create')) class="active" @endif>Add New</a></li>
            </ul>
        </li>
        <li class="sub-menu @if (Request::is(CanvasRoute::routePath('admin.tag.index').'*')) active toggled @endif">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-labels"></i> Tags</a>
            <ul>
                <li><a href="{!! route('admin.tag.index') !!}" @if (Route::is('admin.tag.index')) class="active" @endif>All Tags <span class="label label-default label-totals">{!! Canvas\Models\Tag::count() !!}</span></a></li>
                <li><a href="{!! route('admin.tag.create') !!}" @if (Route::is('admin.tag.create')) class="active" @endif>Add New</a></li>
            </ul>
        </li>
        <li @if (Request::is('admin/upload*')) class="active" @endif><a href="{!! route('admin.upload') !!}"><i class="zmdi zmdi-collection-folder-image"></i> Media</a></li>
        @if(\Canvas\Models\User::isAdmin(Auth::user()->role))
            <li class="sub-menu @if (Request::is(CanvasRoute::routePath('admin.user.index').'*')) active toggled @endif">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-accounts-alt"></i> Users</a>
                <ul>
                    <li><a href="{!! route('admin.user.index') !!}" @if (Route::is('admin.user.index')) class="active" @endif>All Users <span class="label label-default label-totals">{!! Canvas\Models\User::count() !!}</span></a></li>
                    <li><a href="{!! route('admin.user.create') !!}" @if (Route::is('admin.user.create')) class="active" @endif>Add New</a></li>
                </ul>
            </li>
            <li @if (Route::is('admin.tools*')) class="active" @endif><a href="{!! route('admin.tools') !!}"><i class="zmdi zmdi-wrench"></i> Tools</a></li>
            <li @if (Route::is('admin.settings*')) class="active" @endif><a href="{!! route('admin.settings') !!}"><i class="zmdi zmdi-settings"></i> Settings</a></li>
        @endif
        <li @if (Route::is('admin.help')) class="active" @endif><a href="{!! route('admin.help') !!}"><i class="zmdi zmdi-help"></i> Help</a></li>
    </ul>
</aside>
