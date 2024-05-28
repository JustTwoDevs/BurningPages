<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackingRequest extends Model
{
    use HasFactory;
    protected $table = 'backingRequests';

    protected $fillable = [
        'content',
        'user_id',
    ];
    protected $atributes = [
        'state' => 'pending',
    ];

    public function user()
    {
        return $this->belongsTo(RegisteredUser::class, 'user_id');
    }
}
