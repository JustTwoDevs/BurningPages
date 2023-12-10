<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewRate extends Model
{
    use HasFactory;

    
    protected $table = 'reviewRates';

    protected $fillable = [
      
       'value',
         'user_id',
        
    ];
    public function user()
    {
        return $this->belongsTo(RegisteredUser::class, 'user_id');
    }

    public function isBook(): bool
    {
        return BookReviewRate::query()->where('reviewRate_id', $this->id)->exists();
    }
    
    public function isSaga(): bool
    {
        return SagaReviewRate::query()->where('reviewRate_id', $this->id)->exists();
    }


}
