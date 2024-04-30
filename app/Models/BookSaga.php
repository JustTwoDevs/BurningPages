<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookSaga extends Model
{
    use HasFactory;

    protected $table = 'bookSagas';

    protected $fillable = [
        'name',
        'sinopsis',
        'burningmeter',
        'readersScore',
        'image_path',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'bookCollections', 'bookSaga_id', 'book_id')->withPivot('order');
    }

    public function reviews()
    {
        return $this->hasMany(BookSagaReview::class, 'bookSaga_id');
    }


    public function getGenresAttribute()
    {
        return Genre::select('genres.name')
            ->join('bookGenres', 'bookGenres.genre_id', '=', 'genres.id')
            ->join('bookCollections', 'bookCollections.book_id', '=', 'bookGenres.book_id')
            ->where('bookCollections.bookSaga_id', '=', $this->id)
            ->distinct()
            ->get();
    }

    public function getAuthorsAttribute()
    {
        return Author::select('authors.*')
            ->join('bookWriters', 'bookWriters.author_id', '=', 'authors.id')
            ->join('bookCollections', 'bookCollections.book_id', '=', 'bookWriters.book_id')
            ->where('bookCollections.bookSaga_id', '=', $this->id)
            ->distinct()
            ->get();
    }
}
