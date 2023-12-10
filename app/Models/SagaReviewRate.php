<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaReviewRate extends Model
{
    use HasFactory;

    protected $table = 'reviewSagaRates';

    protected $fillable = [
      
        'bookSagaReview_id',
        'reviewRate_id'
        
    ];

    public function bookSagaReview()
    {
        return $this->belongsTo(BookSagaReview::class, 'bookSagaReview_id');
    }

    public function reviewRate()
    {
        return $this->belongsTo(ReviewRate::class, 'reviewRate_id');
    }

}
