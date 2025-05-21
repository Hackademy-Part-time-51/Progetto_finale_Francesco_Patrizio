<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Per la relazione con User
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Per la relazione con Tag

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'slug',
        'image_path',

    ];

    /**
     * Get the user that owns the article.
     * Definisce la relazione "Article Belongs To User" (Un articolo appartiene a un utente).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The tags that belong to the article.
     * Definisce la relazione "Article Belongs To Many Tags" (Un articolo appartiene a molti tag).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}