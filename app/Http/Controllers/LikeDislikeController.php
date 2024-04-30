<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeDislikeController extends Controller
{


    public function like($id, Request $request)
    {

        $post = Posts::findOrFail($id);
        $user = Auth::user()->id;


        $data = $request->all();
        $data['post_id'] = $post->id;
        $data['user_id'] = $user;

        PostLike::create($data);

        return redirect()->back();

    }

    public function unlike($id)
    {

        PostLike::where('post_id', $id)->delete();
        return redirect()->back();

    }


    public function show($id)
    {
        return view('post.detail',['like' => PostLike::all()]);
    }


}
