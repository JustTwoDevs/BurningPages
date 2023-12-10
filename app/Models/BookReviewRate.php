<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReviewRate extends Model
{
    use HasFactory;
    protected $table = 'reviewBookRates';

    protected $fillable = [
        'bookReview_id',
        'reviewRate_id'
    ];

    public function bookReview()
    {
        return $this->belongsTo(BookReview::class, 'bookReview_id');
    }

    public function reviewRate()
    {
        return $this->belongsTo(ReviewRate::class, 'reviewRate_id');
    }
   
}
