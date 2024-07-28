<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\SongDetail;
use App\Models\SongRenewals;
use Livewire\WithPagination;
use App\Services\SongDetailService;

class DashboardTableLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $songDetails;

    public function mount(SongDetailService $service)
    {
        $this->songDetails = $service->getSongDetails();
    }

    // public function render()
    // {
    //     // Retrieve paginated artists with their relationships loaded
    //     $artists = User::withCount(['songs', 'widthraw'])->where('role', 2)->paginate(10);

    //     // Prepare the data to be rendered
    //     $artistData = $artists->map(function ($artist) {
    //         // Get all song details for the artist in a single query with eager loading
    //         $songDetails = $this->songDetails->filter(function ($detail) use ($artist) {
    //             return $detail->song->user_id == $artist->id;
    //         });

    //         // Calculate clean earnings for the artist
    //         $cleanEarning = $songDetails->sum('earnings_usd');

    //         // Calculate artist profit earnings
    //         $artistProfitEarnings = 0;
    //         foreach ($songDetails as $detail) {
    //             $profitPercentage = $detail->song->user->profits
    //                 ->where('effective_date', '<=', $detail->sale_month)
    //                 ->first(function ($profit) use ($detail) {
    //                     return !$profit->end_date || $profit->end_date >= $detail->sale_month;
    //                 });

    //             if ($profitPercentage) {
    //                 $artistProfit = $detail->earnings_usd * ($profitPercentage->profit_percentage / 100);
    //                 $artistProfitEarnings += $artistProfit;
    //             }
    //         }

    //         // Calculate MET profit earnings
    //         $metProfitEarnings = $cleanEarning - $artistProfitEarnings;

    //         // Calculate tax information using SongRenewals
    //         $taxData = SongRenewals::whereHas('song', function ($query) use ($artist) {
    //             $query->where('user_id', $artist->id);
    //         })->get();

    //         $taxCount = $taxData->count();
    //         $taxPayed = $taxData->sum('cost');
    //         $taxProfit = $taxPayed - (6 * $taxCount);

    //         // Calculate artist's receipt and wallet
    //         $receipt = $artist->artistWidthraws_sum_amount ?? 0; // Using eager loaded count
    //         $wallet = $artistProfitEarnings - $receipt - $taxPayed;

    //         return [
    //             'id' => $artist->id,
    //             'name' => $artist->name,
    //             'cleanEarning' => $cleanEarning,
    //             'artistEarning' => $artistProfitEarnings,
    //             'metEarning' => $metProfitEarnings,
    //             'taxCount' => $taxCount,
    //             'taxPayed' => $taxPayed,
    //             'taxProfit' => $taxProfit,
    //             'receipt' => $receipt,
    //             'wallet' => $wallet,
    //             'songsCount' => $artist->songs_count ?? 0, // Using eager loaded count
    //         ];
    //     });

    //     return view('admins.components.dashboardTable', [
    //         'artistData' => $artistData,
    //         'artists' => $artists // Pass the paginated collection for pagination links
    //     ]);
    // }

//     public function render()
// {
//     // Retrieve paginated artists with their relationships loaded
//     $artists = User::withCount(['songs'])
//         ->with(['widthraw', 'songs', 'songs.songDetails'])
//         ->where('role', 2)
//         ->paginate(10);

//     // Prepare the data to be rendered
//     $artistData = $artists->map(function ($artist) {
//         // Get all song details for the artist
//         $songDetails = $artist->songs->flatMap(function ($song) {
//             return $song->songDetails;
//         });

//         // Calculate clean earnings for the artist
//         $cleanEarning = $songDetails->sum('earnings_usd');

//         // Calculate artist profit earnings
//         $artistProfitEarnings = 0;
//         foreach ($songDetails as $detail) {
//             $profitPercentage = $artist->profits
//                 ->where('effective_date', '<=', $detail->sale_month)
//                 ->first(function ($profit) use ($detail) {
//                     return !$profit->end_date || $profit->end_date >= $detail->sale_month;
//                 });

//             if ($profitPercentage) {
//                 $artistProfit = $detail->earnings_usd * ($profitPercentage->profit_percentage / 100);
//                 $artistProfitEarnings += $artistProfit;
//             }
//         }

//         // Calculate MET profit earnings
//         $metProfitEarnings = $cleanEarning - $artistProfitEarnings;

//         // Calculate tax information using SongRenewals
//         $taxData = $artist->songs->flatMap(function ($song) {
//             return $song->songRenewals;
//         });

//         $taxCount = $taxData->count();
//         $taxPayed = $taxData->sum('cost');
//         $taxProfit = $taxPayed - (6 * $taxCount);

//         // Calculate artist's receipt and wallet
//         $receipt = $artist->widthraw->sum('amount') ?? 0;
//         $wallet = $artistProfitEarnings - $receipt - $taxPayed;

//         return [
//             'id' => $artist->id,
//             'name' => $artist->name,
//             'cleanEarning' => $cleanEarning,
//             'artistEarning' => $artistProfitEarnings,
//             'metEarning' => $metProfitEarnings,
//             'taxCount' => $taxCount,
//             'taxPayed' => $taxPayed,
//             'taxProfit' => $taxProfit,
//             'receipt' => $receipt,
//             'wallet' => $wallet,
//             'songsCount' => $artist->songs_count ?? 0,
//         ];
//     });

//     return view('admins.components.dashboardTable', [
//         'artistData' => $artistData,
//         'artists' => $artists // Pass the paginated collection for pagination links
//     ]);
// }

public function render()
{
    // Retrieve paginated artists with their relationships loaded
    $artists = User::withCount(['songs', 'widthraw'])
        ->with(['profits', 'widthraw'])
        ->where('role', 2)
        ->paginate(10);

    // Prepare the data to be rendered
    $artistData = $artists->map(function ($artist) {
        // Get all song details for the artist in a single query with eager loading
        $songDetails = SongDetail::whereHas('song', function ($query) use ($artist) {
            $query->where('user_id', $artist->id);
        })->get();

        // Calculate clean earnings for the artist
        $cleanEarning = $songDetails->sum('earnings_usd');

        // Calculate artist profit earnings
        $artistProfitEarnings = 0;
        foreach ($songDetails as $detail) {
            $profitPercentage = $artist->profits
                ->where('effective_date', '<=', $detail->sale_month)
                ->first(function ($profit) use ($detail) {
                    return !$profit->end_date || $profit->end_date >= $detail->sale_month;
                });

            if ($profitPercentage) {
                $artistProfit = $detail->earnings_usd * ($profitPercentage->profit_percentage / 100);
                $artistProfitEarnings += $artistProfit;
            }
        }

        // Calculate MET profit earnings
        $metProfitEarnings = $cleanEarning - $artistProfitEarnings;

        // Calculate tax information using SongRenewals
        $taxData = SongRenewals::whereHas('song', function ($query) use ($artist) {
            $query->where('user_id', $artist->id);
        })->get();

        $taxCount = $taxData->count();
        $taxPayed = $taxData->sum('cost');
        $taxProfit = $taxPayed - (6 * $taxCount);

        // Calculate artist's receipt and wallet
        $receipt = $artist->widthraw->sum('amount') ?? 0; // Using eager loaded count
        // $wallet = $artistProfitEarnings - $receipt - $taxPayed;
        $wallet = $artistProfitEarnings - $receipt;

        return [
            'id' => $artist->id,
            'name' => $artist->name,
            'cleanEarning' => $cleanEarning,
            'artistEarning' => $artistProfitEarnings,
            'metEarning' => $metProfitEarnings,
            'taxCount' => $taxCount,
            'taxPayed' => $taxPayed,
            'taxProfit' => $taxProfit,
            'receipt' => $receipt,
            'wallet' => $wallet,
            'songsCount' => $artist->songs_count ?? 0, // Using eager loaded count
        ];
    });

    return view('admins.components.dashboardTable', [
        'artistData' => $artistData,
        'artists' => $artists // Pass the paginated collection for pagination links
    ]);
}


}