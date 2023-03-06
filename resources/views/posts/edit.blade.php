@extends('layouts.app')


@section('content')
    
    <div class="container">
        <h1>Modifier un Post</h1>
        <hr>
        <form action="{{ route('posts.update',$post) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label>Titre du Post</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
            value="{{$post->title}}">
            @error('title')
            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="content">Description</label>
            <textarea name="content" id="content" class="form-control
            @error('content') is-invalid @enderror" rows="5">{{$post->content}}</textarea>
            @error('content')
             <div class="invalid-feedback">{{ $errors->first('content') }}</div>   
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Modifier mon post</button>
        </form>
    </div>

@endsection