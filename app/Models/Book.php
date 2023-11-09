<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

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

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'bookGenres', 'book_id', 'genre_id');
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'bookWriters', 'book_id', 'author_id');
    }

    public function bookSagas(): BelongsToMany
    {
        return $this->belongsToMany(BookSaga::class, 'bookCollections', 'book_id', 'bookSaga_id')->withPivot('order');
    }
}
