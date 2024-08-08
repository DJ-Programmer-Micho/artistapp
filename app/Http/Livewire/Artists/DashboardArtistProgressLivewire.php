<?php

namespace App\Http\Livewire\Artists;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SongDetail;
use App\Models\ArtistProfit;

class DashboardArtistProgressLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $storeQuantitiesPage = 1;
    public $storeEarningsPage = 1;
    public $songQuantitiesPage = 1;
    public $songEarningsPage = 1;

    protected $queryString = [
        'storeQuantitiesPage' => ['except' => 1],
        'storeEarningsPage' => ['except' => 1],
        'songQuantitiesPage' => ['except' => 1],
        'songEarningsPage' => ['except' => 1],
    ];

    public function updatingStoreQuantitiesPage()
    {
        $this->resetPage('storeQuantitiesPage');
    }

    public function updatingStoreEarningsPage()
    {
        $this->resetPage('storeEarningsPage');
    }

    public function updatingSongQuantitiesPage()
    {
        $this->resetPage('songQuantitiesPage');
    }

    public function updatingSongEarningsPage()
    {
        $this->resetPage('songEarningsPage');
    }

    private function resetPage($except)
    {
        // Reset all pages except the one specified
        $this->storeQuantitiesPage = $except === 'storeQuantitiesPage' ? $this->storeQuantitiesPage : 1;
        $this->storeEarningsPage = $except === 'storeEarningsPage' ? $this->storeEarningsPage : 1;
        $this->songQuantitiesPage = $except === 'songQuantitiesPage' ? $this->songQuantitiesPage : 1;
        $this->songEarningsPage = $except === 'songEarningsPage' ? $this->songEarningsPage : 1;
    }

    public function getStoreQuantitiesProperty()
    {
        return $this->paginateData('store', 'quantity', $this->storeQuantitiesPage);
    }

    public function getStoreEarningsProperty()
    {
        return $this->paginateStoreEarnings($this->storeEarningsPage);
    }

    public function getSongQuantitiesProperty()
    {
        return $this->paginateData('song_id', 'quantity', $this->songQuantitiesPage, true);
    }

    public function getSongEarningsProperty()
    {
        return $this->paginateData('song_id', 'earnings_usd', $this->songEarningsPage, true);
    }

    private function paginateData($groupBy, $aggregateColumn, $page, $withSong = false)
    {
        $user = Auth::user(); // Get the authenticated user
        
        $query = $this->buildQuery($groupBy, $aggregateColumn, $user->id, $withSong);
        $data = $query->paginate(5, ['*'],  $page); // Use 'page' parameter correctly
    
        if ($withSong && $aggregateColumn === 'earnings_usd') {
            $data->getCollection()->transform(function ($item) use ($user) {
                return $this->calculateEarnings($item, $user);
            });
        }
    
        return $data;
    }
    
    private function buildQuery($groupBy, $aggregateColumn, $userId, $withSong)
    {
        $query = SongDetail::select($groupBy, DB::raw("SUM($aggregateColumn * ".app('deduct').") as total_$aggregateColumn"))
            ->where('user_id', $userId)
            ->groupBy($groupBy)
            ->orderByDesc("total_$aggregateColumn");

        if ($withSong) {
            $query->with('song');
        }

        return $query;
    }

    private function calculateEarnings($item, $user)
    {
        $item->original_earnings_usd = $item->total_earnings_usd; // Store original earnings for reference

        if ($item->song && $item->song->user) {
            $saleMonth = Carbon::parse($item->sale_month);

            $profitPercentage = $this->getProfitPercentage($user->id, $saleMonth);

            if ($profitPercentage) {
                $item->total_earnings_usd = $item->original_earnings_usd * ($profitPercentage->profit_percentage / 100);
            } else {
                $item->total_earnings_usd = 0;
            }
        } else {
            $item->total_earnings_usd = 0;
        }

        return $item;
    }

    private function getProfitPercentage($userId, $saleMonth)
    {
        return ArtistProfit::where('user_id', $userId)
            ->where('effective_date', '<=', $saleMonth->format('Y-m-d'))
            ->where(function ($query) use ($saleMonth) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $saleMonth->format('Y-m-d'));
            })
            ->orderBy('effective_date', 'desc')
            ->first();
    }

    private function paginateStoreEarnings($page)
    {
        $user = Auth::user();
        
        // Query to get the total earnings for each store
        $query = SongDetail::select('store', DB::raw("SUM(earnings_usd * ".app('deduct').") as total_earnings_usd"))
            ->where('user_id', $user->id)
            ->groupBy('store')
            ->orderByDesc('total_earnings_usd');
        
        // Paginate the results
        $data = $query->paginate(5, ['*'], $page); // Ensure 'page' parameter is used correctly

        // Apply artist profit percentage to the paginated data
        $data->getCollection()->transform(function ($item) use ($user) {
            $item->original_earnings_usd = $item->total_earnings_usd; // Store original earnings for reference

            $saleMonth = Carbon::now();

            $profitPercentage = $this->getProfitPercentage($user->id, $saleMonth);

            if ($profitPercentage) {
                $item->total_earnings_usd = $item->original_earnings_usd * ($profitPercentage->profit_percentage / 100);
            } else {
                $item->total_earnings_usd = 0;
            }

            return $item;
        });

        return $data;
    }

    public function render()
    {
        return view('admins.components.dashboardArtistProgress', [
            'storeQuantities' => $this->storeQuantities,
            'storeEarnings' => $this->storeEarnings,
            'songQuantities' => $this->songQuantities,
            'songEarnings' => $this->songEarnings,
        ]);
    }
}
