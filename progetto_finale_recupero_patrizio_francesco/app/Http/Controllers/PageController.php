<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article; 

class PageController extends Controller
{
    public function home()
    {
        $articles = Article::with('user')
                            ->latest()
                            ->take(10)
                            ->get();
        return view('welcome', [
            'articles' => $articles,
        ]);
    }

    /**
     * Mostra un singolo articolo
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function showArticle(Article $article)
    {
        
        $article->load(['user', 'tags']);

        return view('articles.show', [
            'article' => $article,
        ]);
    }
    /**
     * Form dei contatti visualizzato
     * 
     * @return \Illuminate\View\View
     */
    public function showContactForm()
{
    return view('pages.contact');
}
/**
 * Invio del form
 * 
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse 
 */
public function sendContactMessage(Request $request)
{
$validatedData = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'message' => 'required|string|min:10',
]);
return redirect()->route('contact.form')
                 ->with('success','Grazie per il tuo messaggio! Ti risponderemo al più presto!');
}
}