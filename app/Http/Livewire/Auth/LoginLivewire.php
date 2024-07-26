<?php
 
namespace App\Http\Livewire\Auth;

use App\Models\Plan;
use App\Models\User;
use Livewire\Component;
 
class LoginLivewire extends Component
{
    // function mount()
    // {

    // }
   
    public function render()
    {
        return view('auth.components.loginForm');
    }
}