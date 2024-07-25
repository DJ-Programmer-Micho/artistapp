<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\SongDetail;
use Illuminate\Support\Facades\DB;
use App\Services\SongDetailService;

class DashboardArtistChartLivewire extends Component
{
    public $year;
    public $chartData = [];
    public $songDetails;

    public function mount(SongDetailService $service)
    {
        // $this->year = now()->year; // Default to the current year
        $this->year = 2023; // Default to the current year
        $this->songDetails = $service->getSongDetails();
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $startDate = Carbon::create($this->year)->startOfYear();
        $endDate = Carbon::create($this->year)->endOfYear();
    
        $artists = User::where('role', 2)->pluck('id', 'name');
    
        // Fetch all song details for the given year in one query
        $songDetailsAll = $this->songDetails;
        // Initialize chart data array
        $songDetails = $songDetailsAll->filter(function ($detail) use ($startDate, $endDate) {
            $saleMonth = Carbon::parse($detail->sale_month);
            return $saleMonth->between($startDate, $endDate);
        });
        
        $chartData = [];
    
        foreach ($artists as $artistName => $artistId) {
            // Initialize monthly earnings and artist profits arrays for each artist
            $monthlyEarnings = array_fill(1, 12, 0);
            $monthlyArtistProfits = array_fill(1, 12, 0);
    
            // Filter song details for the current artist
            $artistSongDetails = $songDetails->filter(function ($detail) use ($artistId) {
                return $detail->song && $detail->song->user_id == $artistId;
            });
    
            foreach ($artistSongDetails as $detail) {
                // Calculate earnings for the current detail
                $month = Carbon::parse($detail->sale_month)->month;
                $monthlyEarnings[$month] += $detail->earnings_usd;
    
                // Fetch applicable profit percentage for the current song and month
                $profitPercentage = $this->getEffectiveProfitPercentage($detail->song->user->profits, $detail->sale_month);
    
                // Calculate artist profits for the current detail
                $artistProfit = $detail->earnings_usd * ($profitPercentage / 100);
                $monthlyArtistProfits[$month] += $artistProfit;
            }
    
            // Store monthly earnings and artist profits in chartData
            $chartData[$artistName] = [
                'earnings' => array_values($monthlyEarnings),
                'artist_profits' => array_values($monthlyArtistProfits),
                'met_earnings' => array_map(function($clean, $artist) {
                    return $clean - $artist;
                }, $monthlyEarnings, $monthlyArtistProfits),
            ];
        }
    
        $this->chartData = $chartData;
        $this->dispatch('chartDataUpdated', ['chartData' => $this->chartData]);
    }

/**
 * Retrieve effective profit percentage for a given month based on profit history.
 *
 * @param \Illuminate\Database\Eloquent\Collection $profits
 * @param string $month
 * @return float
 */
private function getEffectiveProfitPercentage($profits, $month)
{
    foreach ($profits as $profit) {
        if ($profit->effective_date <= $month && (!$profit->end_date || $profit->end_date >= $month)) {
            return $profit->profit_percentage;
        }
    }
    return 0; // Default to 0 if no applicable percentage found
}

    
    public function render()
    {
        return view('admins.components.dashboardChartArtist');
    }
}
