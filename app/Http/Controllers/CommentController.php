<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Notifications\NewCommentPosted;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Post $post){
        request()->validate([
            'content' => 'required|min:5'
        ]);

        $comment = new Comment();
        $comment->content = request('content');
        $comment->user_id = auth()->user()->id;

        $post->comments()->save($comment);

        // Après l'enregistrement d'un commentaire , on renvoie la notification au créateur du post
        $post->user->notify(new NewCommentPosted($post,auth()->user()));

        return redirect()->route('posts.show',$post);
    }

    public function storeCommentReply(Comment $comment)
    {
        request()->validate([
            'replyComment' => 'required|min:3'
        ]);

        $commentReply = new Comment();
        $commentReply->content = request('replyComment');
        $commentReply->user_id = auth()->user()->id;

        $comment->comments()->save($commentReply);

        return redirect()->back();
    }



}
