<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaReviewRate extends Model
{
    use HasFactory;

    protected $table = 'sagaReviewRates';

    protected $fillable = [
        'value',
        'bookSagaReview_id',
        'user_id',
    ];

    public function bookSagaReview()
    {
        return $this->belongsTo(BookSagaReview::class, 'bookSagaReview_id');
    }

    public function user()
    {
        return $this->belongsTo(RegisteredUser::class, 'user_id');
    }
}
