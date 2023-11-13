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
       'bookReview_id',
         'user_id',
    ];

    public function bookReview(){
        return $this->belongsTo(BookReview::class, 'bookReview_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
