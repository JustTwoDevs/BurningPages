<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';

    protected $fillable = [
        'name',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'authorGenres', 'genre_id', 'author_id');
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'bookGenres', 'genre_id', 'book_id');
    }

    public function bookSagas(): BelongsToMany
    {
        return $this->belongsToMany(BookSaga::class, 'bookSagaGenres', 'genre_id', 'bookSaga_id');
    }
}
