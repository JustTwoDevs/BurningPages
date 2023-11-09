<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookWriters extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'author_id',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Books::class, 'book_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Authors::class, 'author_id');
    }
}
