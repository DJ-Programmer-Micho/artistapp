<?php
 
namespace App\Http\Livewire\Artists;

use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use App\Models\ArtistProfit;
use Livewire\WithPagination;
use App\Models\ArtistWidthraw;
use Illuminate\Support\Facades\Auth;
 
class ArtistWidthrawLivewire extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';
    // INIT
    public $artistList;
    // FILTERS
    public string $search = '';
    
    //MAIN FUNCTIONS
    
    //RENDER VIEW
    public function render()
    {
        $colspan = 5; // Adjusted colspan
        $cols_th = ['#', 'Amount', 'Date', 'Note'];
        $cols_td = ['id', 'amount', 'widthraw_date', 'note'];
    
        // Get the authenticated user
        $authUser = Auth::user();
    
        // Query to get withdrawals along with their users, filtered by authenticated user
        $data = ArtistWidthraw::with('user')
                    ->where('user_id', $authUser->id)
                    ->where(function ($query) {
                        $query->where('amount', 'like', '%' . $this->search . '%')
                              ->orWhere('widthraw_date', 'like', '%' . $this->search . '%')
                              ->orWhereHas('user', function ($query) {
                                  $query->where('name', 'like', '%' . $this->search . '%');
                              });
                    })
                    ->paginate(10);
    
        return view('artists.components.widthrawTable', [
            'items' => $data,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan
        ]);
    }
    
    
}