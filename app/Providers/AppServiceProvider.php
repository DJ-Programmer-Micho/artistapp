<?php

namespace App\Providers;

use App\Services\SongDetailService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SongDetailService::class, function ($app) {
            return new SongDetailService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton('emptyImg', function () {
            return 'https://i.ibb.co/KX2BJDC/MstudioS.jpg'; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('distCloud', function () {
            return 'https://s3.amazonaws.com/gather.fandalism.com/'; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('deduct', function () {
            return 0.84; // Replace "abc" with your desired value or logic to fetch the data.
        });
    }
}
