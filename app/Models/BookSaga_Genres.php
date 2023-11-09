<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookSaga_Genres extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookSaga_id',
        'genre_id'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(BookSaga::class, 'bookSaga_id');
    }

    public function subgenre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }
}
