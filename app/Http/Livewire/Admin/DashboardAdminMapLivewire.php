<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\SongDetail;

class DashboardAdminMapLivewire extends Component
{
    public $geoData = []; // Will hold Geo chart data

    public function mount()
    {
        $this->fetchGeoChartData();
    }

    public function fetchGeoChartData()
    {
        // Fetch aggregated data: Sum quantity by country_of_sale across all users
        $listenersByCountry = SongDetail::groupBy('country_of_sale')
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
        return view('admins.components.dashboardArtistMap');
    }
}
