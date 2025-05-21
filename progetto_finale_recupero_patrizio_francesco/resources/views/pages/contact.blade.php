@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white text-center">
                    <h4>Contattaci</h4>
                </div>
                <div class="card-body p-4">

                    {{-- Mostra il messaggio di successo flashato, se presente --}}
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

                    <p class="mb-4">Hai domande o suggerimenti? Compila il form qui sotto per inviarci un messaggio.</p>

                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf {{-- Token CSRF --}}

                        {{-- Campo Nome --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Il tuo Nome</label>
                               <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
@error('name')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

                        {{-- Campo Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">La tua Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Messaggio --}}
                        <div class="mb-3">
                            <label for="message" class="form-label">Il tuo Messaggio</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-info text-white btn-lg">Invia Messaggio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
