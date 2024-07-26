<?php

namespace App\Services;

use App\Models\SongDetail;
use Illuminate\Support\Facades\Cache;

class SongDetailService
{
    public function getSongDetails()
    {
        return SongDetail::with(['song.user.profits' => function ($query) {
            $query->orderBy('effective_date', 'desc');
        }])->get();
    }
}
