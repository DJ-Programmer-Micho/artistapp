<?php

namespace App\Http\Livewire\Artists;

use Exception;
use App\Models\Song;
use App\Models\User;
use Livewire\Component;
use App\Models\SongDetail;
use App\Models\ArtistProfit;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Jobs\ProcessSongDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;

class DetailLivewire extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // INIT
    // FILTERS
    public $search = '';
    public $statusFilter = '';
    // TEXT FIELDS
    public $data;
    // TEMP VARIABLES
    // TEMP VARIABLES
    // MAIN FUNCTION

       
    public function render()
    {
        $colspan = 5; // Adjusted colspan
        $cols_th = ['#', 'Poster', 'Song Name', 'Artist Profit', 'Status'];
        $cols_td = ['id', 'poster', 'song_name', 'artistProfit', 'status'];

        // Get the authenticated user
        $authUser = Auth::user();

        // Start building query with eager loading and filtering by authenticated user
        $query = Song::with(['user.profile', 'songDetails'])
                    ->where('user_id', $authUser->id);

        // Apply filters
        if ($this->search) {
            $query->where('song_name', 'like', '%' . $this->search . '%');
        }

        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        // Fetch all Song records with applied filters
        $songs = $query->get();

        // Prepare data for the view based on songs
        $data = $songs->map(function ($song) use ($authUser) {
            $artistProfitEarnings = 0;
            foreach ($song->songDetails as $detail) {
                $profitPercentage = $authUser->profits
                    ->where('effective_date', '<=', $detail->sale_month)
                    ->first(function ($profit) use ($detail) {
                        return !$profit->end_date || $profit->end_date >= $detail->sale_month;
                    });

                if ($profitPercentage) {
                    $artistProfit = ($detail->earnings_usd * app('deduct')) * ($profitPercentage->profit_percentage / 100);
                    $artistProfitEarnings += $artistProfit;
                }
            }

            return [
                'id' => $song->id,
                'poster' => $song->poster,
                'song_name' => $song->song_name,
                'artistProfit' => $artistProfitEarnings,
                'status' => $song->status,
            ];
        });

        // Paginate the data
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedData = new LengthAwarePaginator($currentItems, $data->count(), $perPage);

        return view('artists.components.detailTable', [
            'items' => $paginatedData,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan,
        ]);
    }
}
