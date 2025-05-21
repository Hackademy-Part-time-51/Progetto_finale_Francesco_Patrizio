@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="p-5 mb-4 bg-light rounded-3 text-center">
        <div class="container-fluid py-3">
            <h1 class="display-5 fw-bold">{{config('app.name','Il Mio Blog')}}</h1>
            <p class="fs-4">Benvenuto nel mio Blog di curiosità nerd!</p>
        </div>
    </div>
        
    <h2 class="mb-4">Ultimi Articoli</h2>

    @if($articles->count())
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach ($articles as $article)
    <div class="col">
        <div class="card-body">
            <h5 class="card card-title">{{ $article->title}}</h5>
        <p class="card-text">
            {{ Str::Limit(strip_tags($article->content), 150)}}
        </p>
       <a href="{{ route('articles.show', $article) }}" class="btn btn-primary btn-sm">Leggi di più</a>
        </div>
        <div class="card-footer text-muted">Pubblicato il {{ $article->created_at->format('d/m/Y')}}
            @if ($article->user) {{-- Controlla se l'utente esiste (grazie a widht('user')) --}}
                 da {{ $article->user->name }}
            @endif
        </div>
    </div>
</div>
 @endforeach<
</div>
@else<div class="alert alert-info" role="alert">
    Nessun articolo trovato al momento. Torna più tardi!
</div>
@endif
</div>
@endsection