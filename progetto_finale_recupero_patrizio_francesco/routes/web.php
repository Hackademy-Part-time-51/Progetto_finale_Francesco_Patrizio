<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\ArticleController;

Route::get('/',[PageController::class, 'home'])->name('home');
 function () {
    return view('home');
};
Route::get('/articolo/{article}',[PageController::class,'showArticle'])->name('articles.show');
Route::get('/contattaci',[PageController::class, 'showContactForm'])->name('contact.form');
Route::post('/contattaci',[PageController::class,'sendContactMessage'])->name('contact.send');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
Route::resource('articles', ArticleController::class);});