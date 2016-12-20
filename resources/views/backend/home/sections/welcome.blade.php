<div class="card">
    <div class="card-header">
        <h2>Welcome to Canvas!
            <small>Here are some helpful links we've gathered to get you started:
            </small>
        </h2>
    </div>
    <div class="card-body card-padding">
        <div class="row">
            <div class="col-sm-4">
                <h5>Getting Started</h5>
                <br>
                <a href="{{ url('admin/profile') }}" class="btn btn-primary btn-icon-text"><i class="zmdi zmdi-account"></i> Update your Profile</a>
                <br>
                <br>
                <a href="{{ url('admin/settings') }}" class="btn btn-primary btn-icon-text"><i class="zmdi zmdi-settings"></i> Configure your Settings</a>
                <br>
                <br>
            </div>
            <div class="col-sm-4">
                <h5>Next Steps</h5>
                <ul class="getting-started">
                    <li><i class="zmdi zmdi-comment-edit"></i> <a href="{{ url('admin/post/create') }}">Write your first blog post</a></li>
                    <li><i class="zmdi zmdi-plus-circle"></i> <a href="{{ url('admin/tag/create') }}">Create a new tag</a></li>
                    <li><i class="zmdi zmdi-view-web"></i> <a href="{{ url('/') }}" target="_blank">View your site</a></li>
                </ul>
                <br>
            </div>
            <div class="col-sm-4">
                <h5>More Actions</h5>
                <ul class="getting-started">
                    <li><i class="zmdi zmdi-disqus"></i> <a href="{{ url('admin/settings') }}">Disqus Integration</a></li>
                    <li><i class="zmdi zmdi-trending-up"></i> <a href="{{ url('admin/settings') }}">Google Analytics Setup</a></li>
                    <li><i class="zmdi zmdi-wrench"></i> <a href="{{ url('admin/tools') }}">Advanced Tools</a></li></a></li>
                </ul>
                <br>
            </div>
        </div>

        @if($data['canvasVersion'] !== $data['latestRelease'])
            <hr>
            <p class="small" style="margin-bottom: 0;">
                <a href="{{ url('http://github.com/cnvs/canvas/releases/tag/') . $data['latestRelease'] }}" target="_blank"><i class="zmdi zmdi-alert-circle"></i>&nbsp;<strong>Canvas {{ $data['latestRelease'] }}</strong></a> is available! <a href="https://cnvs.readme.io/docs/upgrade-guide" target="_blank"><strong>Please update now.</strong></a>
            </p>
        @endif

    </div>
</div>