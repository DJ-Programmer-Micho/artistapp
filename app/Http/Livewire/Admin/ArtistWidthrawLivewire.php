<?php
 
namespace App\Http\Livewire\Admin;

use App\Models\ArtistProfit;
use App\Models\ArtistWidthraw;
use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
 
class ArtistWidthrawLivewire extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';
    // INIT
    public $artistList;
    // FILTERS
    public string $search = '';
    public $selectArtistFilter  = '';
    // TEXT FIELDS
    public $selectArtist;
    public $amount;
    public $widthrawDate;
    public $note;
    // TEMP VARIABLES
    public $artistWidthrawUpdate;
    public $artist_widthraw_selected_id_delete;
    public $artist_widthraw_selected_name_delete;
    public $nameDelete;
    public $showTextTemp;
    public $confirmDelete;
    public $artistNameToDelete;
    
    //MAIN FUNCTIONS
    function mount()
    {
        $this->artistList = User::orderBy('name', 'ASC')->get();
    }

    //MAIN FUNCTIONS
    function saveWidthraw()
    {
        try{
            // Validation
            $this->validate([
                'selectArtist' => 'required|numeric',
                'amount' => 'required|numeric',
                'widthrawDate' => 'required|date',
                'widthrawDate' => 'required|string',
            ]);

            // Create User
            ArtistWidthraw::create([
                'user_id' => $this->selectArtist,
                'amount' => $this->amount,
                'widthraw_date' => $this->widthrawDate,
                'note' => $this->note,
            ]);

            // Close Modal
            $this->closeModal();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Artist Widthraw Added Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Adding Artist Widthraw')]);
        }
    } // END FUNCTION OF (SAVE ARTIST)
    
    function editWidthraw(int $user_id){
        try {
            // Get Data
            $widthraw_edit = ArtistWidthraw::find($user_id);
            $this->artistWidthrawUpdate = $user_id;
            
            // Store Data
            $this->selectArtist = $widthraw_edit->user_id;
            $this->amount = $widthraw_edit->amount;
            $this->widthrawDate = $widthraw_edit->widthraw_date;
            $this->note = $widthraw_edit->note;

        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Getting Data')]);
        }
    } // END OF FUNCTION (EDIT ARTIST)

    function updateWidthraw(){
        try {
            // Update Artist Widthraw
            ArtistWidthraw::where('id', $this->artistWidthrawUpdate)->update([
                'user_id' => $this->selectArtist,
                'amount' => $this->amount,
                'widthraw_date' => $this->widthrawDate,
                'note' => $this->note,
            ]);

            // Close Modal
            $this->closeModal();
            $this->artistList = User::orderBy('name', 'ASC')->get();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Artist Updated Successfully')]);



        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Updating Artist')]);
        }
    } // END OF FUNCTION (UPDATE ARTIST)

    function deleteWidthraw(int $user_id){
        try {
            $this->artist_widthraw_selected_id_delete = ArtistWidthraw::find($user_id);
            $this->artist_widthraw_selected_name_delete = $this->artist_widthraw_selected_id_delete->user->name ?? "DELETE";
            if($this->artist_widthraw_selected_name_delete){
                $this->nameDelete = $this->artist_widthraw_selected_name_delete;
                $this->showTextTemp = $this->artist_widthraw_selected_name_delete;
                $this->confirmDelete = true;
            } else {
                $this->dispatch('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
            }
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Getting Data')]);
        }
    } // END OF FUNCTION (DELETE ARTIST)

    function destroyWidthraw(){
        try {
            if ($this->confirmDelete && $this->artistNameToDelete === $this->showTextTemp) {
                ArtistWidthraw::find($this->artist_widthraw_selected_id_delete->id)->delete();
                $this->confirmDelete = false;
                $this->artist_widthraw_selected_id_delete = null;
                $this->artist_widthraw_selected_name_delete = null;
                $this->nameDelete = null;
                $this->showTextTemp = null;
                $this->confirmDelete = null;
                $this->closeModal();
            } else {
                $this->dispatch('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
            }
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Artist Deleted Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Deleting Artist')]);
        }
    } // END OF FUNCTION (DESTROY ARTIST)
    
    //UTILITIES
    function closeModal()
    {
        // Reset Form
        $this->selectArtist = [];
        $this->amount = null;
        $this->widthrawDate = null;
        $this->dispatch('close-modal');

        // Close Modal
    } // END OF FUNCTION (CLOSE MODAL)

    
    //RENDER VIEW
    public function render()
    {
        // Delete Check
        if($this->artistNameToDelete == $this->showTextTemp) {
            $this->confirmDelete = true;
        } else {
            $this->confirmDelete = false;
        }


        $colspan = 6;
        $cols_th = ['#','Artist UserName','Amount','Date','Note','Actions'];
        $cols_td = ['id', 'user.name', 'amount','widthraw_date','note'];
    
        // Query to get users along with their profiles
        $data = ArtistWidthraw::with('user')
            ->where(function ($query) {
                $query->where('amount', 'like', '%' . $this->search . '%')
                ->orWhere('widthraw_date', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->selectArtistFilter !== '', function ($query) {
                $query->where('user_id', $this->selectArtistFilter);
            })
            ->paginate(10);
    
        return view('admins.components.widthrawTable', [
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    }
    
}