<?php
 

namespace App\Http\Livewire\Admin;

use App\Models\Song;
use App\Models\User;
use Livewire\Component;
use App\Models\SongDetail;
use App\Models\SongRenewals;
use App\Models\ArtistWidthraw;
use App\Services\SongDetailService;

class DashboardCardLivewire extends Component
{
    public $songDetails;
    //MAIN FUNCTIONS
    public function mount(SongDetailService $service)
    {
        $this->songDetails = $service->getSongDetails();
        // TO DO CHECK AUTH AND ROLE
    }

    //RENDER VIEW
    public function render()
    {
        // Fetch all necessary data with eager loading
        // $songDetails = SongDetail::with(['song.user.profits' => function ($query) {
        //     $query->orderBy('effective_date', 'desc');
        // }])->get();
    
        // Initialize variables for aggregated calculations
        $cleanEarning = 0;
        $artistProfitEarnings = 0;
        $totalTaxes = 0;
        $totalCountTaxes = 0;
        $artistCount = 0;
        $songCount = 0;
        $recipt = 0;
    
        // Prepare collections for efficient data processing
        $users = collect([]);
        $profits = collect([]);
    
        // Iterate through SongDetail collection to aggregate data
        foreach ($this->songDetails as $detail) {
            // Calculate clean earnings
            $cleanEarning += $detail->earnings_usd;
    
            // Prepare user and profit data for artist profit calculation
            $user = $detail->song->user;
            if (!$users->has($user->id)) {
                $users->put($user->id, $user);
            }
    
            // Prepare profit data for current user
            if ($user && !$profits->has($user->id)) {
                $profits->put($user->id, $user->profits->sortByDesc('effective_date')->first());
            }
    
            // Calculate artist profit earnings
            $profitPercentage = $profits->get($user->id) ? $profits->get($user->id)->profit_percentage : 0;
            $artistProfitEarnings += $detail->earnings_usd * ($profitPercentage / 100);
        }
    
        // Calculate MET profit earnings
        $metProfitEarnings = $cleanEarning - $artistProfitEarnings;
    
        // Aggregate queries for taxes and counts
        $totalTaxes = SongRenewals::sum('cost');
        $totalCountTaxes = SongRenewals::count();
        $artistCount = User::where('role', 2)->count();
        $songCount = Song::count();
        $recipt = ArtistWidthraw::sum('amount');
        $wallet = $artistProfitEarnings - $recipt;
    
        // Calculate total earnings including taxes
        $metGrandEarnings = $metProfitEarnings + ($totalTaxes - (6 * $totalCountTaxes));
    
        return view('admins.components.dashboardCard', [
            'cleanEarning' => $cleanEarning,
            'artistProfitEarnings' => $artistProfitEarnings,
            'metProfitEarnings' => $metProfitEarnings,
            'metTotlaEarnings' => $metGrandEarnings,
    
            'qtyTaxes' => $totalCountTaxes,
            'totalTaxes' => $totalTaxes,
            'totalPayedTaxes' => 6 * $totalCountTaxes,
            'totalProfitTaxes' => $totalTaxes - (6 * $totalCountTaxes),
    
            'artistCount' => $artistCount,
            'songCount' => $songCount,
            'recipt' => $recipt,
            'wallet' => $wallet,
        ]);
    }
    
}
