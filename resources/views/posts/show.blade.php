@extends('layouts.app')

@section('extra-js')
    <script>
        function TogglereplyComment(id){
            let element = document.getElementById('replyComment-' + id);
            element.classList.toggle('d-none'); 
        }
    </script>
@endsection

@section('content')
    
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p>{{ $post->content }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <p>Posté : {{ $post->created_at->diffForHumans() }}</p>
                    <span class="badge badge-primary">{{ $post->user->name }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                     <!--Afficher le boutton editer si la fonction update de PostPolicy retourne true-->
                    @can('update', $post)
                    <a href="{{ route('posts.edit',$post) }}" class="btn btn-warning">Editer</a>
                    @endcan
                     <!--Afficher le boutton supprimer si la fonction delete de PostPolicy retourne true-->
                    @can('delete', $post)
                    <form action="{{route('posts.destroy',$post)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                   @endcan
                </div>
            </div>
        </div>
        <hr>
        <h5>Commentaires</h5>
        <!-- Affichage de la totalité des commentaire d'un post -->
        @forelse ($post->comments as $comment)
            <div class="card mb-2">
                <div class="card-body">
                    {{  $comment-> content }}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p>Posté : {{ $comment->created_at->format('d/m/Y') }}</p>
                        <span class="badge badge-primary">{{ $comment->user->name }}</span>
                    </div>
                </div>
            </div>
            <!-- Affichage des réponses de chaque commentaire -->
            @foreach ($comment->comments as $replyComment)
                        <div class="card mb-2 ml-5">
                            <div class="card-body">
                                {{  $replyComment-> content }}
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <p>Posté : {{ $replyComment->created_at->format('d/m/Y') }}</p>
                                    <span class="badge badge-primary">{{ $replyComment->user->name }}</span>
                                </div>
                            </div>
                        </div>
            @endforeach

            <!-- Répondre à des commentaire s'ils existent-->
            <button class="btn btn-secondary mb-3" onclick="TogglereplyComment({{$comment->id}})">Répondre</button>
            <form action="{{ route('comments.storeReply',$comment) }}" method="POST" class="mb-3 ml-5 d-none" id="replyComment-{{$comment->id}}">
                @csrf
                <div class="form-group">
                    <label for="replyComment">Ma réponse</label>
                    <textarea name="replyComment" class="form-control  @error('replyComment') is-invalid @enderror"
                          id="replyComment" rows="5"></textarea>
                    @error('replyComment')
                        <div class="invalid-feedback">{{ $errors->first('replyComment') }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Répondre à ce commentaire</button>
            </form>
        @empty
            <div class="alert alert-info">Aucun commentaire</div>
        @endforelse
        <!-- Laisser des commentaire sur des posts -->
        <form action="{{ route('comments.store',$post) }}" method="post" class="mt-3">
            @csrf
            <div class="form-group">
                <label for="content">Votre commentaire</label>
                <textarea class="form-control @error('content') is-invalid @enderror"
                 name="content" id="content" rows="5"></textarea>
                 @error('content')
                <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                 @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>

    </div>

@endsection