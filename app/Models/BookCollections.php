<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookCollections extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'book_id',
        'bookSaga_id'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function bookSaga(): BelongsTo
    {
        return $this->belongsTo(BookSaga::class, 'bookSaga_id');
    }
}
