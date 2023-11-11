<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';

    protected $fillable = [
        'name',
        'lastname',
        'pseudonym',
        'birth_date',
        'death_date',
        'biography',
        'nationality_id',
    ];

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'bookWriters', 'author_id', 'book_id');
    }

    public function getGenresAttribute()
    {
        return Genre::select('genres.name')
            ->join('bookGenres', 'bookGenres.genre_id', '=', 'genres.id')
            ->join('bookWriters', 'bookWriters.book_id', '=', 'bookGenres.book_id')
            ->where('bookWriters.author_id', '=', $this->id)
            ->distinct()
            ->get();
    }

    public function getBookSagasAttribute()
    {
        return BookSaga::select('bookSagas.*')
            ->join('bookCollections', 'bookCollections.bookSaga_id', '=', 'bookSagas.id')
            ->join('bookWriters', 'bookWriters.book_id', '=', 'bookCollections.book_id')
            ->where('bookWriters.author_id', '=', $this->id)
            ->distinct()
            ->get();
    }
}
