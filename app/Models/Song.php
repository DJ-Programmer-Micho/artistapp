<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'song_name',
        'poster',
        'poster',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function songDetails()
    {
        return $this->hasMany(SongDetail::class);
    }

    public function latestRenewal()
    {
        return $this->hasOne(SongRenewals::class)->latestOfMany('expire_date');
    }
}
