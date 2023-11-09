<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookSaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sinopsis',
        'burningmeter',
        'readersScore',
        'literaryGenre_id'
    ];

    public function bookSagaWriters(): HasMany
    {
        return $this->hasMany(BookSagaWriters::class, 'bookSaga_id');
    }

    public function bookCollections(): HasMany
    {
        return $this->hasMany(BookCollections::class, 'bookSaga_id');
    }

    public function bookSagaGenres(): HasMany
    {
        return $this->hasMany(BookSaga_Genres::class, 'bookSaga_id');
    }
}
