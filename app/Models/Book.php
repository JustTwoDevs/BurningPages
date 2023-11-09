<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'sinopsis',
        'publication_date',
        'original_language',
        'burningmeter',
        'readersScore',
        'buyLink',
        'literaryGenre_id'
    ];

    public function bookWriters(): HasMany
    {
        return $this->hasMany(BookWriters::class, 'book_id');
    }

    public function bookCollections(): HasMany
    {
        return $this->hasMany(BookCollections::class, 'book_id');
    }

    public function bookGenres(): HasMany
    {
        return $this->hasMany(Book_Genres::class, 'book_id');
    }
}
