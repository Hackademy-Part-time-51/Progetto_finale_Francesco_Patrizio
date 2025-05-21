@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Modifica Articolo: {{ $article->title }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Attenzione!</strong> Ci sono stati problemi con i dati inseriti:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Specifica il metodo HTTP PUT per l'aggiornamento --}}

        <div class="mb-3">
            <label for="title" class="form-label">Titolo Articolo</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $article->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Contenuto Articolo</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $article->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tags</label>
            <div class="row">
                @if($tags->count() > 0)
                    @php
                        $articleTagIds = $article->tags->pluck('id')->toArray();
                    @endphp
                    @foreach ($tags as $tag)
                        <div class="col-md-3 col-sm-4 col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}"
                                    {{ (is_array(old('tags')) && in_array($tag->id, old('tags'))) || (!old('tags') && in_array($tag->id, $articleTagIds)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tag{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col">
                        <p>Nessun tag disponibile.</p>
                    </div>
                @endif
            </div>
            @error('tags')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salva Modifiche</button>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Annulla</a>
    </form>
</div>
@endsection