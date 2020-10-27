<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Comment;
use App\Http\Requests\CommentStoreRequest as RequestsCommentStoreRequest;
use App\Http\Resources\Comment as CommentResourse;
use App\Post;

class CommentController extends Controller
{
    public function store(RequestsCommentStoreRequest $request,Post $post)
    {
        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->user()->associate($request->user());

        $post = Post::find($request->id);
        $post->comment()->save($comment);

        return  new CommentResourse($comment);
    }
}
