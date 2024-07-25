<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistWidthraw extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'widthraw_date',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
