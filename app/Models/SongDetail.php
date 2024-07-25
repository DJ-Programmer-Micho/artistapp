<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'song_id',
        'r_date',
        'sale_month',
        'store',
        'quantity',
        'country_of_sale',
        'earnings_usd'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
