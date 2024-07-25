<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'country',
        'city',
        'email',
        'profit',
        'phone',
        'passport_number',
        'youtube_channel',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
