<?php
 
namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
 
class ArtistLivewire extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';
    // INIT

    // FILTERS
    public string $search = '';
    public $statusFilter = '';
    // TEXT FIELDS
    public $firstName;
    public $lastName;
    public $artistName;
    public $country;
    public $city;
    public $metEmail;
    public $password;
    public $status;
    public $profit;
    public $phoneNumber;
    public $passport;
    public $youtube;
    public $officialEmail;
    // TEMP VARIABLES
    public $artistUpdate;
    public $artist_selected_id_delete;
    public $artist_selected_name_delete;
    public $nameDelete;
    public $showTextTemp;
    public $confirmDelete;
    public $artistNameToDelete;
    

    //MAIN FUNCTIONS
    function mount()
    {
        // TO DO CHECK AUTH AND ROLE
    }

    //MAIN FUNCTIONS
    function saveArtist()
    {
        // try{
            // Validation
            $this->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'artistName' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'metEmail' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:6',
                'status' => 'required|boolean',
                'profit' => 'required|integer|min:0|max:100',
                'phoneNumber' => 'required|string|max:255',
                'passport' => 'required|string|max:255|unique:profiles,passport_number',
                'youtube' => 'nullable|string|max:255',
                'officialEmail' => 'nullable|email|max:255|unique:profiles,email',
            ]);

            // Create User
            $user = User::create([
                'name' => $this->artistName,
                'email' => $this->metEmail,
                'password' => $this->password,
                'status' => $this->status,
            ]);

            // Create Profile
            Profile::create([
                'user_id' => $user->id,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'country' => $this->country,
                'city' => $this->city,
                'email' => $this->officialEmail,
                'profit' => $this->profit,
                'phone' => $this->phoneNumber,
                'passport_number' => $this->passport,
                'youtube_channel' => $this->youtube,
            ]);

            // Close Modal
            $this->closeModal();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Artist Added Successfully')]);
        // }  catch (\Exception $e) {
        //     $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Adding Artist')]);
        // }
    } // END FUNCTION OF (SAVE ARTIST)
    
    function editArtist(int $user_id){
        try {
            // Get Data
            $artist_edit = User::find($user_id);
            $this->artistUpdate = $user_id;
            
            // Store Data
            $this->firstName = $artist_edit->profile->first_name;
            $this->lastName = $artist_edit->profile->last_name;
            $this->artistName = $artist_edit->name;
            $this->country = $artist_edit->profile->country;
            $this->city = $artist_edit->profile->city;
            $this->metEmail = $artist_edit->email;
            $this->password = $artist_edit->password;
            $this->status = $artist_edit->status;
            $this->profit = $artist_edit->profile->profit;
            $this->phoneNumber = $artist_edit->profile->phone;
            $this->passport = $artist_edit->profile->passport_number;
            $this->youtube = $artist_edit->profile->youtube_channel;
            $this->officialEmail = $artist_edit->profile->email;

        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Getting Data')]);
        }
    } // END OF FUNCTION (EDIT ARTIST)

    function updateArtist(){
        try {
            // Update User
            User::where('id', $this->artistUpdate)->update([
                'name' => $this->artistName,
                'email' => $this->metEmail,
                'password' => $this->password,
                'status' => $this->status,
            ]);

            // Update Profile
            Profile::where('user_id', $this->artistUpdate)->update([
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'country' => $this->country,
                'city' => $this->city,
                'email' => $this->officialEmail,
                'profit' => $this->profit,
                'phone' => $this->phoneNumber,
                'passport_number' => $this->passport,
                'youtube_channel' => $this->youtube,
            ]);
            // Close Modal
            $this->closeModal();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Artist Updated Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Updating Artist')]);
        }
    } // END OF FUNCTION (UPDATE ARTIST)

    function deleteArtist(int $user_id){
        try {
            $this->artist_selected_id_delete = User::find($user_id);
            $this->artist_selected_name_delete = $this->artist_selected_id_delete->name ?? "DELETE";
            if($this->artist_selected_name_delete){
                $this->nameDelete = $this->artist_selected_name_delete;
                $this->showTextTemp = $this->artist_selected_name_delete;
                $this->confirmDelete = true;
            } else {
                $this->dispatch('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
            }
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Getting Data')]);
        }
    } // END OF FUNCTION (DELETE ARTIST)

    function destroyArtist(){
        try {
            if ($this->confirmDelete && $this->artistNameToDelete === $this->showTextTemp) {
                User::find($this->artist_selected_id_delete->id)->delete();
                $this->confirmDelete = false;
                $this->artist_selected_id_delete = null;
                $this->artist_selected_name_delete = null;
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
        $this->reset();
        $this->dispatch('close-modal');

        // Close Modal
    } // END OF FUNCTION (CLOSE MODAL)

    public function updateStatus(int $user_id)
    {
        try {
            $userState = User::find($user_id);
            // Toggle the status (0 to 1 and 1 to 0)
            $userState->status = $userState->status == 0 ? 1 : 0;
            $userState->save();
            $this->dispatch('alert', ['type' => 'success',  'message' => __('Artist Status Updated Successfully')]);
        }  catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => __('An error occurred while Updating Status')]);
        }
    } // END OF FUNCTION (UPDATE STATUS)
    
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
        $cols_th = ['#','Artist UserName','First Name','First Name','Profit','Status','Actions'];
        $cols_td = ['id', 'name', 'profile.first_name','profile.last_name', 'profile.profit', 'status'];
    
        // Query to get users along with their profiles
        $data = User::where('role', 2)->with('profile')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('profile', function ($query) {
                        $query->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->paginate(10);
    
        return view('admins.components.artistTable', [
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    }
    
}