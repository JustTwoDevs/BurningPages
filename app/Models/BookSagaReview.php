<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class BookSagaReview extends Review
{
    use HasFactory;

    protected $table = 'bookSagaReviews';

    protected $fillable = [
        
        'review_id',
        'bookSaga_id'
    ];

   
    public function review(){
        return $this->belongsTo(Review::class, 'review_id');
    }

    public function bookSaga()
    {
        return $this->belongsTo(BookSaga::class, 'bookSaga_id');
    }
    
    public function reviewSagaRates(){
        return $this->hasMany(SagaReviewRate::class, 'bookSagaReview_id');
    }
}
