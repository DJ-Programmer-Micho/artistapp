<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongRenewals extends Model
{
    use HasFactory;
    protected $fillable = [
        'song_id',
        'release_date',
        'renew_date',
        'expire_date',
        'cost',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
