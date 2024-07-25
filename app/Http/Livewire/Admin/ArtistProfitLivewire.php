<?php
 
namespace App\Http\Livewire\Admin;

use App\Models\ArtistProfit;
use App\Models\ArtistWidthraw;
use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
 
class ArtistProfitLivewire extends Component
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
    public $profitPercentage;
    public $effectiveDate;
    public $endDate;
    // TEMP VARIABLES
    public $artistProfitUpdate;
    public $artist_profit_selected_id_delete;
    public $artist_profit_selected_name_delete;
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
    function saveProfit()
    {
        try{
            // Validation
            $this->validate([
                'selectArtist' => 'required|numeric',
                'profitPercentage' => 'required|numeric',
                'effectiveDate' => 'required|date',
            ]);

            // Create User
            ArtistProfit::create([
                'user_id' => $this->selectArtist,
                'profit_percentage' => $this->profitPercentage,
                'effective_date' => $this->effectiveDate,
                'end_date' => $this->endDate ?? null,
            ]);

            // Close Modal
            $this->closeModal();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Artist Profit Added Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Adding Artist Profit')]);
        }
    } // END FUNCTION OF (SAVE ARTIST)
    
    function editprofit(int $user_id){
        try {
            // Get Data
            $profit_edit = ArtistProfit::find($user_id);
            $this->artistProfitUpdate = $user_id;
            
            // Store Data
            $this->selectArtist = $profit_edit->user_id;
            $this->profitPercentage = $profit_edit->profit_percentage;
            $this->effectiveDate = $profit_edit->effective_date;
            $this->endDate = $profit_edit->end_date;

        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Getting Data')]);
        }
    } // END OF FUNCTION (EDIT ARTIST)

    function updateProfit(){
        try {
            // Update Artist Widthraw
            ArtistProfit::where('id', $this->artistProfitUpdate)->update([
                'user_id' => $this->selectArtist,
                'profit_percentage' => $this->profitPercentage,
                'effective_date' => $this->effectiveDate,
                'end_date' => $this->endDate ?? null,
            ]);

            // Close Modal
            $this->closeModal();
            $this->artistList = User::orderBy('name', 'ASC')->get();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Artist Profit Updated Successfully')]);



        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Updating Artist Profit')]);
        }
    } // END OF FUNCTION (UPDATE ARTIST)

    function deleteProfit(int $user_id){
        try {
            $this->artist_profit_selected_id_delete = ArtistProfit::find($user_id);
            $this->artist_profit_selected_name_delete = $this->artist_profit_selected_id_delete->user->name ?? "DELETE";
            if($this->artist_profit_selected_name_delete){
                $this->nameDelete = $this->artist_profit_selected_name_delete;
                $this->showTextTemp = $this->artist_profit_selected_name_delete;
                $this->confirmDelete = true;
            } else {
                $this->dispatch('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
            }
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Getting Data')]);
        }
    } // END OF FUNCTION (DELETE ARTIST)

    function destroyProfit(){
        try {
            if ($this->confirmDelete && $this->artistNameToDelete === $this->showTextTemp) {
                ArtistProfit::find($this->artist_profit_selected_id_delete->id)->delete();
                $this->confirmDelete = false;
                $this->artist_profit_selected_id_delete = null;
                $this->artist_profit_selected_name_delete = null;
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
        $this->profitPercentage = null;
        $this->effectiveDate = null;
        $this->endDate = null;
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
        $cols_th = ['#','Artist UserName','Profit %','Effective Date','End Date','Actions'];
        $cols_td = ['id', 'user.name', 'profit_percentage','effective_date','end_date'];
    
        // Query to get users along with their profiles
        $data = ArtistProfit::with('user')
            ->where(function ($query) {
                $query->where('profit_percentage', 'like', '%' . $this->search . '%')
                ->orWhere('effective_date', 'like', '%' . $this->search . '%')
                ->orWhere('end_date', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->selectArtistFilter !== '', function ($query) {
                $query->where('user_id', $this->selectArtistFilter);
            })
            ->paginate(10);
    
        return view('admins.components.profitTable', [
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    }
    
}