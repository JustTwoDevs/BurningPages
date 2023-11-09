<?php

namespace App\Models;

use GMP;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book_Genres extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'genre_id'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function subgenre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }
}
