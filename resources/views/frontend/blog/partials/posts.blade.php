@foreach ($posts as $post)
    <div class="post-preview">
        <h2 class="post-title">
            <a href="{{ $post->url($tag) }}">{{ $post->title }}</a>
        </h2>
        <p class="post-meta">
            {{ $post->published_at->diffForHumans() }} &#183; {{ $post->readingTime() }} MIN READ
            <br>
            @if ($post->tags->count())
                @foreach( $post->tagLinks() as $url => $tag )
                    <a href="{{ $url }}">{{ $tag }}</a>&nbsp;
                @endforeach
            @endif
        </p>
        <p class="postSubtitle">
            {{ str_limit($post->subtitle, config('blog.frontend_trim_width')) }}
        </p>
        <p style="font-size: 13px"><a href="{{ $post->url($tag) }}">READ MORE...</a></p>
    </div>
    <hr>
@endforeach