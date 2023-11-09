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

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'authorGenres', 'author_id', 'genre_id');
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'bookWriters', 'author_id', 'book_id');
    }

    public function bookSagas(): BelongsToMany
    {
        return $this->belongsToMany(BookSaga::class, 'bookSagaWriters', 'author_id', 'bookSaga_id');
    }
}
