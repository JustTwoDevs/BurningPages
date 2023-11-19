<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class backingRequest extends Model
{
    use HasFactory;
    protected $table = 'backingRequests';

    protected $fillable = [
        'state',
        'content',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(RegisteredUser::class, 'user_id');
    }
}
