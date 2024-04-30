<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Comments;
use App\Models\PostLike;
use App\Models\Posts;
use App\Models\Tags;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {

        $categoryName = null;
        $tagName = null;
        if (request('category')) {
            $category = Categories::firstWhere('name', request('category'));
            if ($category) {
                $categoryName = $category->name;
            }
        }
        if (request('tag')) {
            $tag = Tags::firstWhere('name', request('tag'));
            if ($tag) {
                $tagName = $tag->name;
            }
        }

        return view('main', [
            'posts' => Posts::paginate(6),
            'pinnedPosts' => Posts::latest()->where('is_pinned', true)->get(),
            "categoryName" => $categoryName,
            "tagName" => $tagName,
            "posts" => Posts::latest()->filter(request(['tag', 'category']))->paginate(6)->withQueryString(),
        ]);
    }

    public function detail($slug)
    {
        $data = Posts::where('slug', $slug)->first();

        $share = \Share::page('http://127.0.0.1/news/', $data->slug)->facebook();

        $comment = Comments::where('post_id', $data->id)->get();

        $data->incrementViews();

        $like = PostLike::where('id',$data->id);

        return view('post.detail', ['data' => $data, 'comment' => $comment, 'share' => $share,"like" => $like]);
    }
}
