<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{

    public function comment(Post $post)
    {
        $comment = new Comment();
        $comment->body = request()->input('comment');
        $comment->user()->associate(Auth::user());
        $comment->post()->associate($post);
        $comment->save();
        return redirect()->back();
    }


}
