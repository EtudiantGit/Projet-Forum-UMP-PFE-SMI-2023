<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //ce constructeur sert à demander l'authentification
    // pour accéder au page servies par les méthodes du controlleur.
    // Pour pertmettre l'execution des méthodes index et show sans demander l'authentification 
    // On remplace par cette ligne : $this->middleware('auth')->except['index','show'];
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:5|max:100',
            'content' => 'required|min:10|max:10000',
        ]);
        $post = auth()->user()->posts()->create($data);
       
        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show',compact('post'));
    }

    public function showFromNotification(Post $post,DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //interdire l'execution de la méthode edit si on n'est pas le propriétaire du post
        $this->authorize('update',$post);
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //interdire l'execution de la méthode update si on n'est pas le propriétaire du post
        $this->authorize('update',$post);

        $data = $request->validate([
            'title' => 'required|min:5|max:100',
            'content' => 'required|min:10|max:10000',
        ]);
        $post->update($data);
        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //interdire l'execution de la méthode destroy si on n'est pas le propriétaire du post
        $this->authorize('delete',$post);

       Post::destroy($post->id);
       return redirect()->route('posts.index');
    }
    public function showmyposts(){
        $posts = Auth::user()->posts()->latest()->paginate(10);
        return view('posts.mesposts',compact('posts'));
    }
}
