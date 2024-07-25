<?php

namespace App\Http\Livewire\Admin;

use Exception;
use App\Models\Song;
use App\Models\User;
use Livewire\Component;
use App\Models\SongDetail;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Jobs\ProcessSongDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class ExcruciatingDetailLivewire extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // INIT
    public $songList;
    public $artistList;
    public $progress = 0;
    // FILTERS
    public $search = '';
    public $statusFilter = '';
    public $selectArtistFilter = '';
    public $selectSongFilter = '';
    // TEXT FIELDS
    public $selectArtist;
    public $selectSong;
    public $data;
    // TEMP VARIABLES
    public $artistNameTmp;
    public $songNameTmp;
    public $fileNameTmp;


    // MAIN FUNCTION
    public function mount()
    {
        $this->artistList = User::orderBy('name', 'ASC')->get();
        $this->songList = Song::orderBy('song_name', 'ASC')->get();
    } // END FUNTION OF (MOUNT)


    // UTILITIES
    public function updateSongList()
    {
        if (!@empty($this->selectArtistFilter)) {
            $this->songList = Song::where('user_id', $this->selectArtistFilter)
                ->orderBy('song_name', 'ASC')->get();
        } else {
            $this->songList = Song::orderBy('song_name', 'ASC')->get();
        }
    } // END FUNTION OF (UPDATE SONG LIST)

    public function render()
    {
        $colspan = 8;
        $cols_th = ['#', 'Poster', 'Song Name', 'Artist', 'Earnings', 'Artist Profit', 'MET Profit'];
        $cols_td = ['id', 'poster', 'song_name', 'user.name', 'earnings_usd', 'artistProfit', 'myProfit'];
    
        $data = Song::with('user')
            ->where(function ($query) {
                $query->where('song_name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->selectArtistFilter !== '', function ($query) {
                $query->where('user_id', $this->selectArtistFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->paginate(1);
    
        $items = $data->items();
        $artistProfits = [];
        $myProfits = [];
    
        foreach ($items as $item) {
            $songId = $item->id;
            $songDetails = SongDetail::where('song_id', $songId)->get();
    
            foreach ($songDetails as $detail) {
                $profitPercentage = $item->user->profits()
                    ->where('effective_date', '<=', $detail->sale_month)
                    ->where(function ($query) use ($detail) {
                        $query->where('end_date', '>=', $detail->sale_month)
                            ->orWhereNull('end_date');
                    })
                    ->orderBy('effective_date', 'desc')
                    ->first();
    
                if ($profitPercentage) {
                    $artistProfit = $detail->earnings_usd * ($profitPercentage->profit_percentage / 100);
                    $myProfit = $detail->earnings_usd - $artistProfit;
                    $artistProfits[$detail->id] = $artistProfit;
                    $myProfits[$detail->id] = $myProfit;
                }
            }
        }
    
        return view('admins.components.excruciatingDetailTable', [
            'items' => $data,
            'artistProfits' => $artistProfits,
            'myProfits' => $myProfits,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan,
        ]);
    }
    
}
