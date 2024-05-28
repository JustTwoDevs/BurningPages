<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = [
        'rate',
        'content',
        'user_id',
    ];
    protected $atributes = [
        'state' => 'draft',
    ];

    public function user()
    {
        return $this->belongsTo(RegisteredUser::class, 'user_id');
    }
    public function isBook(): bool
    {
        return BookReview::query()->where('review_id', $this->id)->exists();
    }
    

    public function isSaga(): bool
    {
        return BookSagaReview::query()->where('review_id', $this->id)->exists();
    }

    public function reviewRates(){
        return $this->hasMany(ReviewRate::class, 'review_id');
    }
}
