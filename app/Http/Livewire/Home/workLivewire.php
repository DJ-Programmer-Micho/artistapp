<?php
 
namespace App\Http\Livewire\Home;

use App\Models\Profile;
use Carbon\Carbon;
use App\Models\Song;
use App\Models\User;
use Livewire\Component;
use App\Models\SongRenewals;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
 
class workLivewire extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';
    //INIT
    public $artistList;
    public $distImgPath;
    public $emptyImg;
    public $artistNameCollection;
    //ON LOAD FUNCTIONS
    function mount()
    {
        $artistNameCollection = [];
    
        // Get 6 random song IDs
        $randomIds = Song::inRandomOrder()->limit(3)->pluck('id')->toArray();
        
        // Retrieve the songs with those IDs
        $this->artistList = Song::whereIn('id', $randomIds)->get();
    
        // Assuming you have a relationship defined in the Song model to get the artist profile
        foreach ($this->artistList as $song) {
            $profile = Profile::where('user_id', $song->user_id)->first();
            if ($profile) {
                $artistName = $profile->first_name . ' ' . $profile->last_name;
                $artistNameCollection[] = $artistName;
            }
        }
        
    
        // Save the collections and other properties
        $this->emptyImg = app('emptyImg');
        $this->distImgPath = app('distCloud');
        
        // Optional: Store the artist names collection
        $this->artistNameCollection = $artistNameCollection;
    
        // Debug output
        // dd($randomIds, $this->artistList, $artistNameCollection);
    }

    public function render()
    {


        return view('main.work', [
            'randomSongs' => $this->artistList,
            'artistNameCollection' => $this->artistNameCollection
        ]);
    }
    
    
}