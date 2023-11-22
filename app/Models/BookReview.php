<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class BookReview extends Review
{
    use HasFactory;

    protected $table = 'bookReviews';

    protected $fillable = [
        'rate',
        'content',
    ];

   public function review(){
         return $this->belongsTo(Review::class, 'review_id');
   }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
    public function user()
    {
        return $this->belongsTo(RegisteredUser::class, 'user_id');
    }

    public function reviewRates(){
        return $this->hasMany(ReviewRate::class, 'bookReview_id');
    }
}
