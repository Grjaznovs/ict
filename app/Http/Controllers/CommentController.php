<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentDestroyRequest;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, $blogId)
    {
        $data = $request->validated();
        $data['blog_id'] = $blogId;
        Auth::user()->comment()->save(new Comment($data));

        return redirect('blog/'.$blogId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommentDestroyRequest $request)
    {
        $data = $request->validated();
        $comment = Comment::findOrFail($data['id']);
        if (Auth::user()->id === $comment->user_id) {
            $comment->delete();
        }

        return Redirect::back();
    }
}
