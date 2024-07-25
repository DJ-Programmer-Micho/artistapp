<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth.pages.login');
    }

    public function login(Request $request){
        //Validate
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);
        
        //Get Info
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        $flag = false;
        if ($user) {
        //     if (password_verify($credentials['password'], $user->g_pass )) {
        //         $flag = true;
        //         Auth::login($user);
        //         $this->verifyUserCheker($user, $credentials);
        // } else {
        //     if (password_verify($credentials['password'], $user->password )) {
        //         $flag = true;
        //         Auth::login($user);
        //         $this->verifyUserCheker($user, $credentials);
        //     }
        // }

        // if (password_verify($credentials['password'], $user->password )) {
        if ($credentials['password'] == $user->password ) {
            $flag = true;
            Auth::login($user);
        }
    } else {
        $flag = false;
        return redirect('/login')->with('alert', [
            'type' => 'error',
            'message' => __('Invalid credentials or user is inactive.'),
        ]);
    }
        
        //Check Auth Role
        if ($user && $user->status == 1 && $flag == true) {
        // if ($user && $user->status == 1 && Auth::attempt($credentials)) {
            $user_role = Auth::user()->role;
    // dd($user_role);
            switch ($user_role) {
                case 1:
                    return redirect('/user100')->with('alert', [
                        'type' => 'success',
                        'message' => __('Dashboard Is Ready'),
                    ]);
                    break;
                case 2:
                    return redirect('/artist')->with('alert', [
                        'type' => 'success',
                        'message' => __('Welcome Mr/Mrs') . $user->profile->fullname,
                    ]);
                    break;
                default:
                    Auth::logout();
                    return redirect('/login')->with('alert', [
                        'type' => 'error',
                        'message' => __('Something Went Wrong'),
                    ]);
            }
        } else {
            return redirect('/login')->with('alert', [
                'type' => 'error',
                'message' => __('Account Has Been Suspended.'),
            ]);
        }
    } // END Function (Login Fucntion)

    public function logout(){
        auth()->logout();
        return back();
    } // END Function (Logout)
}
