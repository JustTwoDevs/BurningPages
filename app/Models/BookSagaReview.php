<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookSagaReview extends Model
{
    use HasFactory;

    protected $table = 'bookSagaReviews';

    protected $fillable = [
        'rate',
        'content',
        'state',
        'bookSaga_id',
    ];

    
    public function bookSaga()
    {
        return $this->belongsTo(BookSaga::class, 'bookSaga_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reviewSagaRate(){
        return $this->hasMany(SagaReviewRate::class, 'bookSagaReview_id');
    }
}
