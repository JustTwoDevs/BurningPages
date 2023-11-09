<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookSagaWriters extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookSaga_id',
        'author_id',
    ];

    public function bookSaga(): BelongsTo
    {
        return $this->belongsTo(BookSaga::class, 'bookSaga_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Authors::class, 'author_id');
    }
}
