<?php

namespace App\Services;

use App\Models\SongDetail;
use Illuminate\Support\Facades\Cache;

class SongDetailService
{
    public function getSongDetails()
    {
        // return SongDetail::with(['song.user.profits' => function ($query) {
        //     $query->orderBy('effective_date', 'desc');
        // }])->get();

        // Adding Deduct 14%
        return SongDetail::with(['song.user.profits' => function ($query) {
            $query->orderBy('effective_date', 'desc');
        }])->get()->each(function ($detail) {
            $detail->earnings_usd = $detail->earnings_usd * app('deduct'); // Deduct 14%
        });
    }
}
