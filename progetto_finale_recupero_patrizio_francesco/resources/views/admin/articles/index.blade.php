@extends('layouts.app') {{-- Usa il nostro layout principale Bootstrap --}}

@section('content')
<div class="container py-4">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Gestione Articoli</h1>
        </div>
        <div class="col-md-6 text-md-end">
            {{-- Link per creare un nuovo articolo (lo implementeremo dopo) --}}
            <a href="{{ route('admin.articles.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Crea Nuovo Articolo
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            I Miei Articoli
        </div>
        <div class="card-body">
            @if($articles->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titolo</th>
                                <th scope="col">Creato il</th>
                                <th scope="col">Ultima Modifica</th>
                                <th scope="col" class="text-end">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <a href="{{ route('articles.show', $article) }}" target="_blank" title="Visualizza articolo (vista pubblica)">
                                            {{ $article->title }}
                                        </a>
                                    </td>
                                    <td>{{ $article->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $article->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-end">
                                        {{-- Link per modificare (lo implementeremo dopo) --}}
                                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary btn-sm me-2">
                                            <i class="fas fa-edit"></i> Modifica
                                        </a>
                                        {{-- Form per cancellare (lo implementeremo dopo) --}}
                                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare questo articolo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Elimina
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Link per la paginazione --}}
                <div class="mt-3">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    Non hai ancora creato nessun articolo. <a href="{{ route('admin.articles.create') }}">Inizia ora!</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- Per le icone Font Awesome (se non lo hai già incluso globalmente) --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" /> --}}
@endpush