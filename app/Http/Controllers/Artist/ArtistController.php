<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function dashboard(){
        return view('artists.pages.dashboard');
    }
    public function map(){
        return view('artists.pages.map');
    }
    public function songs(){
        return view('artists.pages.song');
    }
    public function expire(){
        return view('artists.pages.expire');
    }
    public function artistWidthraw(){
        return view('artists.pages.widthraw');
    }
}
