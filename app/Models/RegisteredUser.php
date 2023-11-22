<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredUser extends Model
{
    use HasFactory;
    protected $table = 'registeredUsers';
    public $timestamps = false;

    protected $fillable = [
        'rank',
        'user_id',
        'verified',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }
    public function reviewRates()
    {
        return $this->hasMany(reviewRate::class, 'user_id');
    }
   
    public function sagaReviewRates()
    {
        return $this->hasMany(SagaReviewRate::class, 'user_id');
    }
    public function backingRequests()
    {
        return $this->hasMany(BackingRequest::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
