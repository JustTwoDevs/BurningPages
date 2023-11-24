<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BookReview extends Review
{
    use HasFactory;

    protected $table = 'bookReviews';

    protected $fillable = [
      
        'book_id',
        'review_id'
    ];

   public function review(){
         return $this->belongsTo(Review::class, 'review_id');
   }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }


    public function reviewRates(){
        return $this->hasMany(BookReviewRate::class, 'bookReview_id');
    }
}
