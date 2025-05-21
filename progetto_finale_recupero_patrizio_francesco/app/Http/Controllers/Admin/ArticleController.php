<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Tag;
use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest; // Aggiunto per l'update
use Illuminate\Http\Request; // Mantenuto per lo stub di show se necessario
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $articles = $user->articles()->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('admin.articles.create', compact('tags'));
    }

    public function store(StoreArticleRequest $request)
    {
        $validatedData = $request->validated();

        $article = new Article();
        $article->user_id = Auth::id();
        $article->title = $validatedData['title'];
        $article->content = $validatedData['content'];

        $baseSlug = Str::slug($validatedData['title']);
        $article->slug = $baseSlug;
        $counter = 1;
        while (Article::where('slug', $article->slug)->exists()) {
            $article->slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $article->save();

        if (!empty($validatedData['tags'])) {
            $article->tags()->sync($validatedData['tags']);
        } else {
            $article->tags()->detach();
        }

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Articolo creato con successo!');
    }

    public function show(Article $article)
    {
        // Reindirizza alla vista pubblica dell'articolo
        return redirect()->route('articles.show', $article);
    }

    public function edit(Article $article)
    {
        if (Auth::id() !== $article->user_id) {
            abort(403, 'Non sei autorizzato a modificare questo articolo.');
        }
        $tags = Tag::all();
        return view('admin.articles.edit', compact('article', 'tags'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        // L'autorizzazione è gestita da UpdateArticleRequest
        $validatedData = $request->validated();

        $article->title = $validatedData['title'];
        $article->content = $validatedData['content'];

        if ($request->filled('title') && $article->isDirty('title')) {
            $baseSlug = Str::slug($validatedData['title']);
            $newSlug = $baseSlug;
            $counter = 1;
            while (Article::where('slug', $newSlug)->where('id', '!=', $article->id)->exists()) {
                $newSlug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $article->slug = $newSlug;
        } elseif (isset($validatedData['slug']) && !empty($validatedData['slug'])) {
             // Se lo slug viene inviato esplicitamente e validato, usalo
             // Assicurati che la logica di unicità sia gestita anche dalla FormRequest per lo slug
             $article->slug = $validatedData['slug'];
        }
        // Se lo slug non viene inviato o il titolo non cambia, lo slug esistente viene mantenuto


        $article->save();

        if (isset($validatedData['tags'])) { // Controlla se 'tags' è presente, anche se è un array vuoto
            $article->tags()->sync($validatedData['tags']);
        } else {
            $article->tags()->detach(); // Rimuove tutti i tag se la chiave 'tags' non è presente nella richiesta
        }

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Articolo aggiornato con successo!');
    }

    public function destroy(Article $article)
    {
        if (Auth::id() !== $article->user_id) {
            abort(403, 'Non sei autorizzato a eliminare questo articolo.');
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Articolo eliminato con successo!');
    }
}