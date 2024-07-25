<?php

namespace App\Http\Livewire\Artists;

use Livewire\Component;
use App\Models\SongDetail;
use Illuminate\Support\Facades\Auth;

class DashboardArtistMapLivewire extends Component
{
    public $geoData = []; // Will hold Geo chart data

    public function mount()
    {
        $this->fetchGeoChartData();
    }

    public function fetchGeoChartData()
    {
        $user = Auth::user();

        // Fetch aggregated data: Sum quantity by country_of_sale for the authenticated user
        $listenersByCountry = SongDetail::where('user_id', $user->id)
            ->groupBy('country_of_sale')
            ->selectRaw('country_of_sale, SUM(quantity) as total_listeners')
            ->get();

        // Prepare data for Geo chart
        $this->geoData = $listenersByCountry->map(function ($item) {
            return [
                'code' => $item->country_of_sale,
                'listeners' => (int) $item->total_listeners, // Use raw number for color scaling
                'formatted_listeners' => formatNumber($item->total_listeners), // Formatted number for display
            ];
        })->toArray();

        // Emit the data to JavaScript
        $this->dispatch('fetchGeoChartData', ['geoData' => $this->geoData]);
    }
    public function render()
    {
        return view('artists.components.dashboardArtistMap');
    }
}
