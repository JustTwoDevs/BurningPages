<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    use HasFactory;

    protected $table = 'bookReviews';

    protected $fillable = [
        'rate',
        'content',
        'state',
        'book_id',
        'user_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
    public function user()
    {
        return $this->belongsTo(RegisteredUser::class, 'user_id');
    }
    public function reviewRate()
    {
        return $this->hasMany(ReviewRate::class, 'bookReview_id');
    }
}
