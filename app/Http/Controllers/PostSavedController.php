<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\SavedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostSavedController extends Controller
{
    public function save(Posts $post)
    {
       $saved = $post->savedPost(Auth::user()->id);

       if($saved){
        Session::flash('message', "Postingan berhasil di tambahkan ke favorit");
       }

        return back();
    }

    public function unsave(Posts $post)
    {
      $unsaved =  $post->unsavedPost(auth()->id());

      if($unsaved){
        Session::flash('massage', "Postingan berhasil di hapus dari favorit");
       }

        return redirect()->back();
    }

    public function detail($post)
    {
        $postsaves = SavedPost::where('user_id', $post)->get();
        foreach ($postsaves as $ps) {
            $post = Posts::findOrFail($ps->post_id);
            $ps->post = $post;
        }
        return view('post.saved', compact('postsaves'));
    }
}
