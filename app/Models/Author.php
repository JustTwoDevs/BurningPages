<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Author extends Model
{
    use HasFactory;

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

    public function bookWriters(): HasMany
    {
        return $this->hasMany(BookWriters::class, 'author_id');
    }

    public function bookSagaWriters(): HasMany
    {
        return $this->hasMany(BookSagaWriters::class, 'author_id');
    }

    public function author_genres(): HasMany
    {
        return $this->hasMany(Author_Genres::class, 'author_id');
    }
}
