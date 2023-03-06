@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="list-groupe">
            @foreach ($posts as $post)
                <div class="list-group-item mb-2">
                    <h4><a href="{{route('posts.show',$post)}}">{{ $post->title }}</a></h4>
                    <p>{{ $post->content }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <p>Posté : {{ $post->created_at->diffForHumans() }}</p>
                        <span class="badge badge-primary">{{ $post->user->name }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $posts->links() }}
        </div>
    </div>

@endsection