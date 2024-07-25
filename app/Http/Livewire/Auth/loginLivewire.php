<?php
 
namespace App\Http\Livewire\Auth;

use App\Models\Plan;
use App\Models\User;
use Livewire\Component;
 
class loginLivewire extends Component
{
    // function mount()
    // {

    // }
   
    public function render()
    {
        return view('auth.components.loginForm');
    }
}