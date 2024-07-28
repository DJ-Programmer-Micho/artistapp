<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admins.pages.dashboard');
    }
    public function dashboardTable(){
        return view('admins.pages.dashboardTable');
    }
    public function dashboardChart(){
        return view('admins.pages.dashboardChart');
    }
    public function map(){
        return view('admins.pages.map');
    }
    public function artist(){
        return view('admins.pages.artist');
    }
    public function song(){
        return view('admins.pages.song');
    }
    public function detail(){
        return view('admins.pages.detail');
    }
    public function exdetail(){
        return view('admins.pages.excruciatingDetail');
    }
    public function artistProfit(){
        return view('admins.pages.profit');
    }
    public function artistWidthraw(){
        return view('admins.pages.widthraw');
    }
}
