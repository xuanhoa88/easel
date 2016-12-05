<?php

namespace Canvas\Http\Controllers\Frontend;

use Auth;
use Canvas\Models\Tag;
use Canvas\Models\Post;
use Canvas\Models\User;
use Illuminate\Http\Request;
use Canvas\Jobs\BlogIndexData;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Display the blog index page.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tag = $request->get('tag');
        $data = $this->dispatch(new BlogIndexData($tag));
        $layout = $tag ? Tag::layout($tag)->first() : config('blog.tag_layout');

        return view($layout, $data);
    }

    /**
     * Display a blog post page.
     *
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showPost($slug, Request $request)
    {
        $post = Post::with('tags')->whereSlug($slug)->firstOrFail();
        $user = User::where('id', $post->user_id)->firstOrFail();
        $tag = $request->get('tag');
        $title = $post->title;
        if ($tag) {
            $tag = Tag::whereTag($tag)->firstOrFail();
        }

        if ($post->is_draft && ! Auth::check()) {
            return redirect('/blog');
        }

        return view($post->layout, compact('post', 'tag', 'slug', 'title', 'user'));
    }
}
