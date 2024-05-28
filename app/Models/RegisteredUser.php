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
        'user_id',
        'verified',
        'likeDifference',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }


    public function reviewRates()
    {
        return $this->hasMany(ReviewRate::class, 'user_id');
    }


    public function backingRequests()
    {
        return $this->hasMany(BackingRequest::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rank()
    {
        if ($this->likeDifference <= -51) return "booed";
        if ($this->likeDifference >= -50 && $this->likeDifference <= 49) return "neutral";
        if ($this->likeDifference >= 50 && $this->likeDifference <= 149) return "bronze";
        if ($this->likeDifference >= 150 && $this->likeDifference <= 349) return "silver";
        if ($this->likeDifference >= 350) return "gold";
    }
}
