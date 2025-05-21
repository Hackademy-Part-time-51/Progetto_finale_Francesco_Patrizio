@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- Pulsante Indietro --}}
            <div class="mb-4">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Torna alla Homepage
                </a>
            </div>

            <article class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    {{-- Titolo dell'articolo --}}
                    <h1 class="card-title display-5 mb-3">{{ $article->title }}</h1>

                    {{-- Meta informazioni: Autore e Data --}}
                    <div class="mb-4 text-muted">
                        <span>
                            Pubblicato il: {{ $article->created_at->format('d F Y, H:i') }}
                        </span>
                        @if($article->user)
                            <span class="mx-2">|</span>
                            <span>Scritto da: {{ $article->user->name }}</span>
                        @endif
                    </div>

                    {{-- Contenuto dell'articolo --}}
                    <div class="article-content fs-5">
                        {!! nl2br(e($article->content)) !!} {{-- nl2br per i "a capo", e() per la sicurezza --}}
                    </div>

                    {{-- Tags (se presenti) --}}
                    @if($article->tags && $article->tags->count() > 0)
                        <hr class="my-4">
                        <div class="mt-4">
                            <h5 class="mb-2">Tags:</h5>
                            @foreach($article->tags as $tag)
                                <a href="#" class="btn btn-info btn-sm me-2 mb-2 disabled">#{{ $tag->name }}</a>
                                {{-- Il link per il tag per ora è disabilitato (# e classe disabled)
                                     Potremmo creare pagine per i tag più avanti --}}
                            @endforeach
                        </div>
                    @endif
                </div>
            </article>

        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- Se vuoi aggiungere stili specifici per questa pagina --}}
<style>
    .article-content img { 
        max-width: 100%;
        height: auto;
    }
</style>
{{-- Per l'icona freccia, assicurati di avere Font Awesome o simile, o usa un carattere SVG/Testo --}}
{{-- Se non hai Font Awesome, puoi sostituire <i class="fas fa-arrow-left"></i> con "&laquo;" o "←" --}}
@endpush