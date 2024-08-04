<?php
 
namespace App\Http\Livewire\Home;

use Carbon\Carbon;
use App\Models\Song;
use App\Models\User;
use Livewire\Component;
use App\Models\SongRenewals;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
 
class HomeLivewire extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';
    //INIT
    public $artistList;
    public $distImgPath;
    public $distViewer;
    public $emptyImg;
    //FILTERS
    public $search = '';
    public $statusFilter = '';
    public $selectArtistFilter = '';
    //TEXT FIELDS
    public $selectArtist;
    public $songName;
    public $poster;
    public $releaseDate;
    public $renewDate;
    public $expireDate;
    public $status;
    public $cost;
    // TEMP VARIABLES
    public $songUpdate;
    public $song_selected_id_delete;
    public $song_selected_name_delete;
    public $nameDelete;
    public $showTextTemp;
    public $confirmDelete;
    public $songNameToDelete;
    
    //ON LOAD FUNCTIONS
    function mount()
    {
        // $this->artistList = User::orderBy('name', 'ASC')->get();
        // $this->emptyImg = app('emptyImg');
        // $this->distImgPath = app('distCloud');
    }

    //RENDER VIEW
    // public $sortBy = 'latestRenewal.expire_date'; // Default sort by expire date
    // public $sortDirection = 'asc'; // Default sort direction

    public function render()
    {
        // Check for delete confirmation
        // $this->confirmDelete = $this->songNameToDelete == $this->showTextTemp;
    
        // // Define table columns
        // $cols_th = ['#', 'Poster', 'Song Name', 'Release Date', 'Expire Date', 'Status'];
        // $cols_td = ['id', 'poster', 'song_name', 'latestRenewal.release_date', 'latestRenewal.expire_date', 'status'];
    
        // // Get the authenticated user
        // $authUser = Auth::user();
    
        // // Base query to fetch songs with filters and sorting, filtered by authenticated user
        // $query = Song::with(['user', 'latestRenewal'])
        //              ->where('user_id', $authUser->id)
        //              ->when($this->search, function ($query, $search) {
        //                  $query->where(function ($query) use ($search) {
        //                      $query->where('song_name', 'like', '%' . $search . '%')
        //                            ->orWhereHas('user', function ($query) use ($search) {
        //                                $query->where('name', 'like', '%' . $search . '%');
        //                            });
        //                  });
        //              })
        //              ->when($this->selectArtistFilter, function ($query, $artistFilter) {
        //                  $query->where('user_id', $artistFilter);
        //              })
        //              ->when($this->statusFilter, function ($query, $statusFilter) {
        //                  $query->where('status', $statusFilter);
        //              });
    
        // // Count songs based on filters or all songs
        // $songCount = $query->count();
    
        // // Fetch paginated data with latest renewal information
        // $data = $query
        //     ->leftJoin('song_renewals as latestRenewal', function ($join) {
        //         $join->on('songs.id', '=', 'latestRenewal.song_id')
        //              ->whereRaw('latestRenewal.id = (select max(id) from song_renewals where song_id = songs.id)');
        //     })
        //     ->orderBy('latestRenewal.expire_date', $this->sortDirection)
        //     ->select('songs.*')
        //     ->paginate(10);
    
        // // Transform data to calculate daysDifference for each item
        // $data->getCollection()->transform(function ($item) {
        //     $item->expire_days_difference = $item->latestRenewal
        //         ? Carbon::parse($item->latestRenewal->expire_date)->diffInDays(now(), false)
        //         : null;
    
        //     return $item;
        // });
    
        // Table column definitions
        // $colspan = count($cols_th);
    
        return view('main.home', [
            // 'items' => $data,
            // 'cols_th' => $cols_th,
            // 'cols_td' => $cols_td,
            // 'colspan' => $colspan,
            // 'song_count' => $songCount,
        ]);
    }
    
    
}