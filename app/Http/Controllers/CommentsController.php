<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Posts;
use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommentsController extends Controller
{
    public function index(Comments $comment)
    {
        return view('post.detail', ['comments' => $comment]);
    }

    public function show($id)
    {
        $comment = Comments::findOrFail($id);

        return view('post.detail', compact('comment'));
    }



    public function StoreComment(Request $request)
    {

        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = new Comments();
        $comment->post_id = $request->post_id;
        $comment->content = $validatedData['content'];
        $comment->user_id = Auth::user()->id;


        if ($validatedData['parent_id'] !== null) {
            $parentComment = Comments::find($validatedData['parent_id']);
            $comment->parent_id = $parentComment->id;
        }

        $comment->save();

        return redirect()->back();



    }

    public function destroy(Comments $id)
    {
        $delete =  $id->destroy($id->id);
        if ($delete) {
            Session::flash("success", "Komentar anda berhasil di deleted");
        }
        return redirect()->back();
    }

    public function update(Comments $id, Request $request)
    {

        $request->validate([
            'content' => 'required'
        ]);

        $data =
            [
                'content' => $request->content
            ];

        $find = Comments::findOrFail($id->id);
        $find->update($data);

        return redirect()->back();
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable'
        ]);

        dd($id);

        Comments::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->back();
    }
}
