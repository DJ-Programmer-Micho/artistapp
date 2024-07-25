<?php

namespace App\Http\Livewire\Artists;

use App\Models\Song;
use App\Models\User;
use Livewire\Component;
use App\Models\SongDetail;
use App\Models\SongRenewals;
use App\Models\ArtistWidthraw;
use App\Services\SongDetailService;
use Illuminate\Support\Facades\Auth;

class DashboardCardLivewire extends Component
{
    public $subscribe;
    public $views;
    public $uploads;
    public $songDetails;

    //MAIN FUNCTIONS
    function mount($subscribe, $views, $uploads, SongDetailService $service)
    {
        $this->subscribe = $subscribe;
        $this->views = $views;
        $this->uploads = $uploads;
        $this->songDetails = $service->getSongDetails();
    }

    //RENDER VIEW
    public function render()
    {
        $user = Auth::user();

        // Initialize variables
        $artistProfitEarnings = 0;
        $totalTaxes = 0;
        $songCount = 0;
        $recipt = 0;

        // Process SongDetail records in chunks
        SongDetail::whereHas('song', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['song.user.profits' => function ($query) {
            $query->orderBy('effective_date', 'desc');
        }])->chunk(1000, function ($songDetailsChunk) use (&$artistProfitEarnings, $user) {
            foreach ($songDetailsChunk as $detail) {
                $profitPercentage = $detail->song->user->profits
                    ->where('effective_date', '<=', $detail->sale_month)
                    ->first(function ($profit) use ($detail) {
                        return !$profit->end_date || $profit->end_date >= $detail->sale_month;
                    });

                if ($profitPercentage) {
                    $artistProfitEarnings += $detail->earnings_usd * ($profitPercentage->profit_percentage / 100);
                }
            }
        });

        // Calculate total taxes
        $totalTaxes = SongRenewals::whereHas('song', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('cost');

        // Count songs
        $songCount = Song::where('user_id', $user->id)->count();

        // Sum receipts
        $recipt = ArtistWidthraw::where('user_id', $user->id)->sum('amount');

        // Calculate wallet balance
        $wallet = $artistProfitEarnings - $totalTaxes - $recipt;

        return view('artists.components.dashboardCard', [
            'artistProfitEarnings' => $artistProfitEarnings,
            'totalTaxes' => $totalTaxes,
            'songCount' => $songCount,
            'recipt' => $recipt,
            'wallet' => $wallet,
        ]);
    }
}
