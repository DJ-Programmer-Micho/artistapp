<?php

namespace App\Http\Livewire\Artists;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Song;
use App\Models\SongDetail;
use App\Services\SongDetailService;
use Illuminate\Support\Facades\DB;

class DashboardArtistChartLivewire extends Component
{
    public $year;
    public $chartData = [];
    public $songDetails;

    public function mount(SongDetailService $service)
    {
        $this->year = now()->year; // Default to the current year
        $this->songDetails = $service->getSongDetails();

        $this->loadChartData();
    }

    public function loadChartData()
    {
        $startDate = Carbon::create($this->year)->startOfYear();
        $endDate = Carbon::create($this->year)->endOfYear();
    
        $user = Auth::user(); // Get the currently authenticated user
    
        // Fetch all songs associated with the user
        $songs = Song::where('user_id', $user->id)->get();
    
        // Initialize chart data
        $chartData = [];
    
        foreach ($songs as $song) {
            // Initialize monthly earnings array for the current song
            $artistProfitEarnings = array_fill(1, 12, 0);
    
            // Fetch earnings data for the current song
            $earningsData = SongDetail::select(
                    DB::raw('MONTH(sale_month) as month'),
                    DB::raw('SUM(earnings_usd) as total_earnings')
                )
                ->where('song_id', $song->id)
                ->whereBetween('sale_month', [$startDate, $endDate])
                ->groupBy(DB::raw('MONTH(sale_month)'))
                ->get();
    
            // Loop through each month's earnings data
            foreach ($earningsData as $earnings) {
                // Fetch the applicable profit percentage for the current month
                $profitPercentage = $song->user->profits()
                    ->where('effective_date', '<=', $startDate->copy()->month($earnings->month))
                    ->where(function ($query) use ($startDate) {
                        $query->where('end_date', '>=', $startDate)
                            ->orWhereNull('end_date');
                    })
                    ->orderBy('effective_date', 'desc')
                    ->first();
    
                // If a profit percentage is found, calculate artist earnings for the month
                if ($profitPercentage) {
                    $artistProfit = $earnings->total_earnings * ($profitPercentage->profit_percentage / 100);
                    $artistProfitEarnings[$earnings->month] += $artistProfit;
                }
            }
    
            // Store the monthly earnings data including artist earnings in chartData with the song name as key
            $chartData[$song->song_name] = $artistProfitEarnings;
        }
    
        // Emit the updated chart data to the frontend
        $this->chartData = $chartData;
        $this->dispatch('chartDataUpdated', ['chartData' => $this->chartData]);
    }
    


    public function render()
    {
        return view('artists.components.dashboardChartArtist');
    }
}
