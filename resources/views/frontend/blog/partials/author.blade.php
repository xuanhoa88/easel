<img style="float: left; width: 60px" class="img-responsive img-circle author-img" src="https://www.gravatar.com/avatar/{{ md5($user->email) }}?d=identicon&s=150" title="{{ $user->first_name .  ' ' . $user->last_name }}">
<div style="overflow: hidden">
    <h4 id="auth-name"><strong>{{ $user->first_name .  ' ' . $user->last_name }}</strong></h4>
    <span class="small" style="margin-top: 0">
        {{ $user->bio }}
        <br>
        @if (!empty($user->twitter))
            <a href="https://twitter.com/{{ $user->twitter }}" target="_blank" id="social"><i class="fa fa-fw fa-twitter text-muted" style="font-size: 14px"></i></a>
        @endif
        @if (!empty($user->facebook))
            <a href="https://facebook.com/{{ $user->facebook }}" target="_blank" id="social"><i class="fa fa-fw fa-facebook text-muted" style="font-size: 14px"></i></a>
        @endif
        @if (!empty($user->github))
            <a href="https://github.com/{{ $user->github }}" target="_blank" id="social"><i class="fa fa-fw fa-github text-muted" style="font-size: 14px"></i></a>
        @endif
        @if(!empty($user->linkedin))
            <a href="https://linkedin.com/in/{{ $user->linkedin }}" target="_blank" id="social"><i class="fa fa-fw fa-linkedin text-muted" style="font-size: 14px"></i></a>
        @endif
    </span>
</div>