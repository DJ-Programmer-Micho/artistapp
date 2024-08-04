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
    
    //ON LOAD FUNCTIONS

    public function render()
    {
 
        return view('main.home');
    }
    
    
}