<?php

namespace App\Http\Livewire\Admin;

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
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;

class DetailLivewire extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // INIT
    public $songList = [];
    public $artistList;
    public $progress = 0;
    // FILTERS
    public $search = '';
    public $statusFilter = '';
    public $selectArtistFilter = '';
    // TEXT FIELDS
    public $selectArtist;
    public $selectSong;
    public $data;
    // TEMP VARIABLES
    public $artistNameTmp;
    public $songNameTmp;
    public $fileNameTmp;
    // TEMP VARIABLES
    public $songUpdate;
    public $song_selected_id_delete;
    public $song_selected_name_delete;
    public $nameDelete;
    public $showTextTemp;
    public $confirmDelete;
    public $songNameToDelete;

    // MAIN FUNCTION
    public function mount()
    {
        $this->artistList = User::where('role',2)->orderBy('name', 'ASC')->get();
    } // END FUNTION OF (MOUNT)


    public function saveSongDetails()
    {
        // set_time_limit(300);
        // try {
            // Validate input fields
            $this->validate([
                'selectArtist' => 'required',
                'selectSong' => 'required',
                'data' => 'required|file|mimes:tsv,txt',
            ]);
    
            // Store uploaded file and get its path
            $path = $this->data->store('livewire-tmp');
            $tsvFile = storage_path('app/' . $path);
    
            // Convert TSV to CSV
            $csvFile = $this->convertTsvToCsv($tsvFile);
    
            // Read the CSV file contents
            $fileContents = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if ($fileContents === false) {
                Log::info('Failed to read the CSV file.');
                throw new \Exception('Failed to read the CSV file.');
            }
    
            // Skip the header row
            array_shift($fileContents);
    
            // Delete existing song details for the selected artist and song
            SongDetail::where('user_id', $this->selectArtist)
                ->where('song_id', $this->selectSong)
                ->delete();
    
            // Insert data in chunks
            $this->insertSongDetailsInChunks($fileContents);
            Log::info('CSV file contents:', ['contents' => $fileContents]);
            // Post-process actions
            $this->postProcess($tsvFile, $csvFile);
        // } catch (\Exception $e) {
        //     $this->dispatch('alert', ['type' => 'error', 'message' => __('There was an error adding the song details. Please try again.')]);
        //     Log::error('Error adding song details:', ['error' => $e->getMessage()]);
        // }
    }
    private function insertSongDetailsInChunks($fileContents)
    {
        dd($fileContents); // this is not empty
        $chunkSize = 1000; // Adjust based on performance testing
        $chunks = array_chunk($fileContents, $chunkSize);

        foreach ($chunks as $chunk) {
            $records = [];

            foreach ($chunk as $line) {
                // $lineData = str_getcsv($line); // WIN OS
                $lineData = str_getcsv(trim($line, '"')); // LINUX OS
                if (count($lineData) === 13) {
                    $records[] = [
                        'user_id' => $this->selectArtist,
                        'song_id' => $this->selectSong,
                        'r_date' => date('Y-m-d', strtotime($lineData[0])),
                        'sale_month' => date('Y-m-d', strtotime($lineData[1])),
                        'store' => $lineData[2],
                        'quantity' => (int) $lineData[7],
                        'country_of_sale' => $lineData[10],
                        'earnings_usd' => (float) $lineData[12],
                    ];
                }
            }
            Log::info('Processed records before dispatch:', ['records' => $records]);

            // Dispatch job for each chunk
            if (!empty($records)) {
                ProcessSongDetails::dispatch($records);
            } else {
                Log::info('No records to process.');
            }
        }
    }
    
    
    
    private function postProcess($tsvFile, $csvFile)
    {
        // Delete the TSV and CSV files after processing
        $this->dispatch('alert', ['type' => 'success', 'message' => __('Song details added successfully.')]);
        $this->dispatch('stopTimer');
        $this->dispatch('close-modal-confirmation');
        // Update progress and timer
        $this->progress = 0;
        $this->closeModal();
        File::delete($tsvFile, $csvFile);
        // set_time_limit(60);
    }
    
    private function convertTsvToCsv($tsvFilePath)
    {
        $csvFilePath = str_replace('.tsv', '.csv', $tsvFilePath);

        // Run the Python script to convert TSV to CSV
        $pythonScriptPath = base_path('scripts/convert_tsv_to_csv.py');
        // $command = escapeshellcmd("python3 {$pythonScriptPath} {$tsvFilePath}"); //python2
        // $command = escapeshellcmd("python3 {$pythonScriptPath} {$tsvFilePath}"); //python3
        $venvPythonPath = '/home/ubuntu/myenv/bin/python'; // AWS EC2 Path
        $command = escapeshellcmd("{$venvPythonPath} {$pythonScriptPath} {$tsvFilePath}");
        shell_exec($command);

        // Capture the output and error messages
        exec($command . ' 2>&1', $output, $return_var);

        // Log the output for debugging
        Log::info('Python script output: ' . implode("\n", $output));
        Log::info('Python script return status: ' . $return_var);



        if (!file_exists($csvFilePath)) {
            throw new \Exception('CSV file conversion failed.');
        }

        return $csvFilePath;
    }


    // UTILITIES
    public function updateSongList()
    {
        if ($this->selectArtist) {
            $this->songList = Song::where('user_id', $this->selectArtist)
                ->orderBy('song_name', 'ASC')->get();
        }
    } // END FUNTION OF (UPDATE SONG LIST)

    public function confirmationData()
    {
        try {

        $this->validate([
            'selectArtist' => 'required',
            'selectSong' => 'required',
            'data' => 'required|file|mimes:tsv,txt',
        ]);
        
        // Retrieve the selected artist and song from the database
        $selectedArtist = User::find($this->selectArtist);
        $selectedSong = Song::find($this->selectSong);
    
        // Ensure the selected artist and song exist
        if (!$selectedArtist || !$selectedSong) {
            $this->dispatch('alert', ['type' => 'error',  'message' => __('Selected artist or song not found.')]);
            return;
        }
    
        // Assign temporary values for confirmation modal
        $this->artistNameTmp = $selectedArtist->name;
        $this->songNameTmp = $selectedSong->song_name;
        $this->fileNameTmp = $this->data->getClientOriginalName();
    
        // Show the confirmation modal here
        $this->dispatch('close-modal');
        $this->dispatch('showConfirmationModal');
        $this->dispatch('alert', ['type' => 'success',  'message' => __('Song details Checked')]);

        } catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error',  'message' => __('Something Went Wrong.')]);

            Log::info('progress record:', ['record' => $e]);
        } // END FUNTION OF (COMFIRMATION DATA)
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

    public function closeModal()
    {
        $this->dispatch('close-modal');
        $this->dispatch('close-modal-confirmation');
        
        $this->songList = [];
        $this->artistList = User::orderBy('name', 'ASC')->get();
        $this->progress = 0;
        $this->selectArtist = "";
        $this->selectSong = "";
        $this->data = null;
        $this->artistNameTmp = "";
        $this->songNameTmp = "";
        $this->fileNameTmp = "";

        $this->dispatch('filepond-reset');
    } // END FUNTION OF (CLOSE MODAL)




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





    // RENDER

//     public function render()
// {
//     $colspan = 9;
//     $cols_th = ['#', 'Poster', 'Song Name', 'Artist', 'Earnings', 'Artist Profit', 'MET Profit', 'Status', 'Actions'];
//     $cols_td = ['id', 'poster', 'song_name', 'user', 'earnings_usd', 'artistProfit', 'myProfit', 'status'];

//     // Fetch all Song records with their associated user
//     $songs = Song::with('user')->get();

//     // Fetch earnings per song and store them in an array
//     $earnings = SongDetail::selectRaw('song_id, sum(earnings_usd) as total_earnings')
//         ->groupBy('song_id')
//         ->pluck('total_earnings', 'song_id')
//         ->toArray();

//     // Fetch all ArtistProfit records and organize them by user_id
//     $artistProfits = ArtistProfit::get()
//         ->groupBy('user_id')
//         ->map(function ($profitGroup) {
//             return $profitGroup->sortByDesc('effective_date')->first();
//         });

//     // Prepare data for the view
//     $data = $songs->map(function ($song) use ($earnings, $artistProfits) {
//         $totalEarnings = $earnings[$song->id] ?? 0;
//         $profitPercentage = $artistProfits[$song->user_id]->profit_percentage ?? 0;
//         $artistProfit = $totalEarnings * ($profitPercentage / 100);
//         $myProfit = $totalEarnings - $artistProfit;

//         return [
//             'id' => $song->id,
//             'poster' => $song->poster,
//             'song_name' => $song->song_name,
//             'user' => $song->user->profile->first_name . ' ' . $song->user->profile->last_name ?? 'Unknown',
//             'earnings_usd' => $totalEarnings,
//             'artistProfit' => $artistProfit,
//             'myProfit' => $myProfit,
//             'status' => $song->status,
//         ];
//     });

//     // Paginate the data
//     $perPage = 10;
//     $currentPage = LengthAwarePaginator::resolveCurrentPage();
//     $currentItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->all();
//     $paginatedData = new LengthAwarePaginator($currentItems, $data->count(), $perPage);

//     return view('admins.components.detailTable', [
//         'items' => $paginatedData,
//         'cols_th' => $cols_th,
//         'cols_td' => $cols_td,
//         'colspan' => $colspan,
//     ]);
// }
    
    
public function render()
{
    $colspan = 9;
    $cols_th = ['#', 'Poster', 'Song Name', 'Artist', 'Earnings', 'Artist Profit', 'MET Profit', 'Status', 'Actions'];
    $cols_td = ['id', 'poster', 'song_name', 'user', 'earnings_usd', 'artistProfit', 'myProfit', 'status'];

    // Start building query with eager loading
    $query = Song::with('user.profile', 'songDetails');

    // Apply filters
    if ($this->search) {
        $query->where('song_name', 'like', '%' . $this->search . '%')
              ->orWhereHas('user', function ($query) {
                  $query->where('name', 'like', '%' . $this->search . '%');
              });
    }

    if ($this->selectArtistFilter) {
        $query->where('user_id', $this->selectArtistFilter);
    }

    if ($this->statusFilter !== '') {
        $query->where('status', $this->statusFilter);
    }

    // Fetch all Song records with applied filters
    $songs = $query->get();

    // Fetch earnings per song and store them in an array
    $earnings = SongDetail::selectRaw('song_id, sum(earnings_usd) as total_earnings')
        ->groupBy('song_id')
        ->pluck('total_earnings', 'song_id')
        ->toArray();

    // Fetch all ArtistProfit records and organize them by user_id
    $artistProfits = ArtistProfit::get()
        ->groupBy('user_id')
        ->map(function ($profitGroup) {
            return $profitGroup->sortByDesc('effective_date')->first();
        });

    // Prepare data for the view based on songs
    $data = $songs->map(function ($song) use ($earnings, $artistProfits) {
        $totalEarnings = $earnings[$song->id] ?? 0;
        $profitPercentage = $artistProfits[$song->user_id]->profit_percentage ?? 0;
        $artistProfit = $totalEarnings * ($profitPercentage / 100);
        $myProfit = $totalEarnings - $artistProfit;

        return [
            'id' => $song->id,
            'poster' => $song->poster,
            'song_name' => $song->song_name,
            'user' => $song->user->profile->first_name . ' ' . $song->user->profile->last_name ?? 'Unknown',
            'earnings_usd' => $totalEarnings,
            'artistProfit' => $artistProfit,
            'myProfit' => $myProfit,
            'status' => $song->status,
        ];
    });

    // Paginate the data
    $perPage = 10;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $currentItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->all();
    $paginatedData = new LengthAwarePaginator($currentItems, $data->count(), $perPage);

    return view('admins.components.detailTable', [
        'items' => $paginatedData,
        'cols_th' => $cols_th,
        'cols_td' => $cols_td,
        'colspan' => $colspan,
    ]);
}

    
    

}
