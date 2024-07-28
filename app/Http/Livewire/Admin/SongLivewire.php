<?php
 
namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Song;
use App\Models\User;
use Livewire\Component;
use App\Models\SongRenewals;
use Livewire\WithPagination;
 
class SongLivewire extends Component
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
        $this->artistList = User::orderBy('name', 'ASC')->get();
        $this->emptyImg = app('emptyImg');
        $this->distImgPath = app('distCloud');
    }

    //MAIN FUNCTIONS
    function saveSong()
    {
        try {
            // Validation
            $this->validate([
                'selectArtist' => 'required',
                'songName' => 'required|string|max:255',
                'releaseDate' => 'required|date',
                'expireDate' => 'required|date',
                'cost' => 'required|numeric',
                'poster' => 'required|string|max:255',
                'status' => 'required|boolean', 
            ]);
    
            // Create Song
            $songId = Song::create([
                'user_id' => $this->selectArtist,
                'song_name' => $this->songName,
                'poster' => $this->poster,
                'status' => $this->status,
            ]);

            SongRenewals::create([
                'song_id' => $songId->id,
                'release_date' => $this->releaseDate,
                'renew_date' => null,
                'expire_date' => $this->expireDate,
                'cost' => $this->cost,
            ]);
    
            // Close Modal
            $this->closeModal();
    
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Song Added Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Adding Song')]);
        }
    } // FUNCTION OF (SAVE SONG)

    function editSong(int $song_id) {
        try {
            // Get Data
            $song_edit = Song::with('latestRenewal')->find($song_id);
            $this->songUpdate = $song_id;
            
            // Store Data
            $this->selectArtist = $song_edit->user_id;
            $this->songName = $song_edit->song_name;
            $this->releaseDate = $song_edit->latestRenewal->release_date;
            $this->renewDate = $song_edit->latestRenewal->renew_date ?? null;
            $this->expireDate = $song_edit->latestRenewal->expire_date;
            $this->cost = $song_edit->latestRenewal->cost;
            $this->poster = $song_edit->poster;
            $this->status = $song_edit->status;
            $this->posterViewer();

        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Getting Data')]);
        }
    } // FUNCTION OF (EDIT SONG)

    function updateSong() {
        try {
            // Update Song
            Song::where('id', $this->songUpdate)->update([
                'user_id' => $this->selectArtist,
                'song_name' => $this->songName,
                'poster' => $this->poster,
                'status' => $this->status,
            ]);

            SongRenewals::where('song_id', $this->songUpdate)->update([
                'release_date' => $this->releaseDate,
                'expire_date' => $this->expireDate,
                'cost' => $this->cost,
            ]);


            $this->closeModal();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Song Updated Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Updating Song')]);
        }
    } // FUNCTION OF (UPDATE SONG)

    function renewSong() {
        try {
            // Validation
            $this->validate([
                'selectArtist' => 'required',
                'songName' => 'required|string|max:255',
                'releaseDate' => 'required|date',
                'expireDate' => 'required|date',
                'cost' => 'required|numeric',
                'poster' => 'required|string|max:255',
                'status' => 'required|boolean', 
            ]);
    
            SongRenewals::create([
                'song_id' => $this->songUpdate,
                'release_date' => $this->releaseDate,
                'renew_date' => $this->renewDate,
                'expire_date' => $this->expireDate,
                'cost' => $this->cost,
            ]);
    
            // Close Modal
            $this->closeModal();
    
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Song Added Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Adding Song')]);
        }
    } // FUNCTION OF (UPDATE SONG)

    function deleteSong(int $song_id){
        try {
            $this->song_selected_id_delete = Song::find($song_id);
            $this->song_selected_name_delete = $this->song_selected_id_delete->song_name ?? "DELETE";
            if($this->song_selected_name_delete){
                $this->confirmDelete = true;
                $this->nameDelete = $this->song_selected_name_delete;
                $this->showTextTemp = $this->song_selected_name_delete;
            } else {
                $this->dispatch('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
            }
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Getting Data')]);
        }
    } // END OF FUNCTION (DELETE SONG)

    function destroySong(){
        try {
            if ($this->confirmDelete && $this->songNameToDelete === $this->showTextTemp) {
                Song::find($this->song_selected_id_delete->id)->delete();
                $this->song_selected_id_delete = null;
                $this->song_selected_name_delete = null;
                $this->nameDelete = null;
                $this->showTextTemp = null;
                $this->confirmDelete = null;
                $this->confirmDelete = false;
                $this->closeModal();
            } else {
                $this->dispatch('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
                return;
            }
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Song Deleted Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Deleting Song')]);
        }
    } // END OF FUNCTION (DESTROY SONG)


    function deleteRenew(int $song_id){
        try {
            $this->showTextTemp = $song_id;
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Getting Data')]);
        }
    } // END OF FUNCTION (DELETE SONG)

    function destroyRenew(){
        try {
                SongRenewals::find($this->showTextTemp)->delete();
                $this->song_selected_id_delete = null;
                $this->song_selected_name_delete = null;
                $this->nameDelete = null;
                $this->showTextTemp = null;
                $this->confirmDelete = null;
                $this->confirmDelete = false;
                $this->closeModalRenew();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Song Deleted Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Deleting Song')]);
        }
    } // END OF FUNCTION (DESTROY SONG)


    public $renewalsHistory = [];

    function calendarSong(int $song_id)
    {
        try {
            $this->renewalsHistory = SongRenewals::with('song')->where('song_id', $song_id)->get();

        } catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while fetching renewal history')]);
        }
    }

    function editRenew(int $song_id) {
        try {
            // Get Data
            $song_renew_edit = SongRenewals::with('song')->find($song_id);
            $this->songUpdate = $song_renew_edit;
            
            // Store Data
            $this->songName = $song_renew_edit->song->song_name;
            $this->releaseDate = $song_renew_edit->release_date;
            $this->renewDate = $song_renew_edit->renew_date ?? null;
            $this->expireDate = $song_renew_edit->expire_date;
            $this->cost = $song_renew_edit->cost;
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Getting Data')]);
        }
    } // FUNCTION OF (EDIT SONG)

    function updateRenew() {
        try {
            
            // Update Song
            SongRenewals::where('id', $this->songUpdate->id)->update([
                'release_date' => $this->releaseDate,
                'renew_date' => $this->renewDate,
                'expire_date' => $this->expireDate,
                'cost' => $this->cost,
            ]);


            $this->closeModalRenew();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Song Updated Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Updating Song')]);
        }
    } // FUNCTION OF (UPDATE SONG)

    
    //UTILITIES
    function posterViewer()
    {
        $this->distViewer = $this->distImgPath . $this->poster;
    }

    function addYear()
    {
        if($this->renewDate) {
            $this->expireDate = Carbon::parse($this->renewDate)->addYear()->toDateString();
        } else {
            $this->expireDate = Carbon::parse($this->releaseDate)->addYear()->toDateString();
        }
    }

    function closeModal()
    {
        // Reset Form
        $this->reset(['selectArtist', 'songName', 'poster', 'status','releaseDate','expireDate']);
        $this->dispatch('close-modal');
    }

    function closeModalRenew()
    {
        // Reset Form
        $this->dispatch('close-modal-renew');
    }

    public function updateStatus(int $user_id)
    {
        try {
            $userState = Song::find($user_id);
            // Toggle the status (0 to 1 and 1 to 0)
            $userState->status = $userState->status == 0 ? 1 : 0;
            $userState->save();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Artist Status Updated Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Updating Status')]);
        }
    } // FUNCTION OF (UPDATE STATUS)
    //RENDER VIEW
    public $sortBy = 'latestRenewal.expire_date'; // Default sort by expire date
    public $sortDirection = 'asc'; // Default sort direction

    public function render()
    {
        // Check for delete confirmation
        $this->confirmDelete = $this->songNameToDelete == $this->showTextTemp;
    
        // Define table columns
        $cols_th = ['#', 'Poster', 'Song Name', 'Artist', 'Release Date', 'Expire Date', 'Status', 'Actions'];
        $cols_td = ['id', 'poster', 'song_name', 'user.name', 'latestRenewal.release_date', 'latestRenewal.expire_date', 'status'];
    
        // Base query to fetch songs with filters and sorting
        $query = Song::with(['user', 'latestRenewal'])
            ->when($this->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('song_name', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($this->selectArtistFilter, function ($query, $artistFilter) {
                $query->where('user_id', $artistFilter);
            })
            ->when($this->statusFilter, function ($query, $statusFilter) {
                $query->where('status', $statusFilter);
            });
    
        // Count songs based on filters or all songs
        $songCount = $query->count();
    
        // Fetch paginated data with latest renewal information
        $data = $query
            ->leftJoin('song_renewals as latestRenewal', function ($join) {
                $join->on('songs.id', '=', 'latestRenewal.song_id')
                    ->whereRaw('latestRenewal.id = (select max(id) from song_renewals where song_id = songs.id)');
            })
            ->orderBy('latestRenewal.expire_date', $this->sortDirection)
            ->select('songs.*')
            ->paginate(10);
    
        // Transform data to calculate daysDifference for each item
        $data->getCollection()->transform(function ($item) {
            $item->expire_days_difference = $item->latestRenewal
                ? Carbon::parse($item->latestRenewal->expire_date)->diffInDays(now(), false)
                : null;
    
            return $item;
        });
    
        // Table column definitions
        $colspan = count($cols_th);
    
        return view('admins.components.songTable', [
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan,
            'song_count' => $songCount,
        ]);
    }
    
}