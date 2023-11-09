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
        'literaryGenre_id'
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'bookSagaGenres', 'bookSaga_id', 'genre_id');
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'bookSagaWriters', 'bookSaga_id', 'author_id');
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'bookCollections', 'bookSaga_id', 'book_id')->withPivot('order');
    }
}
