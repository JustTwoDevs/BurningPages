<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function author_genres(): HasMany
    {
        return $this->hasMany(Author_Genres::class, 'genre_id');
    }

    public function book_genres(): HasMany
    {
        return $this->hasMany(Book_Genres::class, 'genre_id');
    }

    public function bookSaga_genres(): HasMany
    {
        return $this->hasMany(BookSaga_Genres::class, 'genre_id');
    }
}
