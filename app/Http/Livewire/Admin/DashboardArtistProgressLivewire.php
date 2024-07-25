<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SongDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $this->resetPageExcept('storeQuantitiesPage');
    }

    public function updatingStoreEarningsPage()
    {
        $this->resetPageExcept('storeEarningsPage');
    }

    public function updatingSongQuantitiesPage()
    {
        $this->resetPageExcept('songQuantitiesPage');
    }

    public function updatingSongEarningsPage()
    {
        $this->resetPageExcept('songEarningsPage');
    }

    public function resetPageExcept($except)
    {
        $this->storeQuantitiesPage = $except == 'storeQuantitiesPage' ? $this->storeQuantitiesPage : 1;
        $this->storeEarningsPage = $except == 'storeEarningsPage' ? $this->storeEarningsPage : 1;
        $this->songQuantitiesPage = $except == 'songQuantitiesPage' ? $this->songQuantitiesPage : 1;
        $this->songEarningsPage = $except == 'songEarningsPage' ? $this->songEarningsPage : 1;
    }

    public function getStoreQuantitiesProperty()
    {
        return $this->paginateData('store', 'quantity', 'storeQuantitiesPage');
    }

    public function getStoreEarningsProperty()
    {
        return $this->paginateData('store', 'earnings_usd', 'storeEarningsPage');
    }

    public function getSongQuantitiesProperty()
    {
        return $this->paginateData('song_id', 'quantity', 'songQuantitiesPage', true);
    }

    public function getSongEarningsProperty()
    {
        return $this->paginateData('song_id', 'earnings_usd', 'songEarningsPage', true);
    }

    private function paginateData($groupBy, $aggregateColumn, $page, $withSong = false)
    {
        $query = SongDetail::select($groupBy, DB::raw("SUM($aggregateColumn) as total_$aggregateColumn"))
            ->groupBy($groupBy)
            ->orderByDesc("total_$aggregateColumn");

        if ($withSong) {
            $query->with('song');
        }

        $data = $query->paginate(5, ['*'], $page);

        return $data;
    }

    public function render()
    {
        // dd($this->songQuantities);
        return view('admins.components.dashboardArtistProgress', [
            'storeQuantities' => $this->storeQuantities,
            'storeEarnings' => $this->storeEarnings,
            'songQuantities' => $this->songQuantities,
            'songEarnings' => $this->songEarnings,
        ]);
    }
}
