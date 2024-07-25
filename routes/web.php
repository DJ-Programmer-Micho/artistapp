<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Artist\ArtistController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Main Page Route
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class,'index'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('logging');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');



/*
|--------------------------------------------------------------------------
| Admnin Route
|--------------------------------------------------------------------------
*/
// 'LocalizationMiddleware',
Route::prefix('/user100')->middleware(['checkStatus', 'adminAuth'])->group(function () {
    Route::get('/', [AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/map', [AdminController::class,'map'])->name('admin.map');
    Route::get('/artists', [AdminController::class,'artist'])->name('admin.artist');
    Route::get('/songs', [AdminController::class,'song'])->name('admin.song');
    Route::get('/detail', [AdminController::class,'detail'])->name('admin.detail');
    Route::get('/excruciating-detail', [AdminController::class,'exdetail'])->name('admin.exdetail');
    Route::get('/artist-widthraw', [AdminController::class,'artistWidthraw'])->name('admin.artistWidthraw');
    Route::get('/artist-profit', [AdminController::class,'artistProfit'])->name('admin.artistProfit');
});

/*
|--------------------------------------------------------------------------
| Artist Route
|--------------------------------------------------------------------------
*/
// 'LocalizationMiddleware',
Route::prefix('/artist')->middleware(['checkStatus', 'artistAuth'])->group(function () {
    Route::get('/', [ArtistController::class,'dashboard'])->name('artist.dashboard');
    Route::get('/map', [ArtistController::class,'map'])->name('artist.map');
    Route::get('/songs', [ArtistController::class,'songs'])->name('artist.song');
    Route::get('/expire', [ArtistController::class,'expire'])->name('artist.expire');
    Route::get('/artist-widthraw', [ArtistController::class,'artistWidthraw'])->name('artist.artistWidthraw');
    // Route::get('/artists', [ArtistController::class,'artist'])->name('artist.artist');
    // Route::get('/songs', [ArtistController::class,'song'])->name('artist.song');
    // Route::get('/detail', [ArtistController::class,'detail'])->name('artist.detail');
    // Route::get('/excruciating-detail', [ArtistController::class,'exdetail'])->name('artist.exdetail');
    // Route::get('/artist-widthraw', [ArtistController::class,'artistWidthraw'])->name('artist.artistWidthraw');
    // Route::get('/artist-profit', [ArtistController::class,'artistProfit'])->name('artist.artistProfit');
});



Route::get('/', function () {
    return view('welcome');
});