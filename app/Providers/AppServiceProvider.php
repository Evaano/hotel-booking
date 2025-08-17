<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add human-readable date format macros
        Carbon::macro('toHumanDate', function () {
            return $this->format('M d, Y'); // Jan 01, 2023
        });

        Carbon::macro('toHumanDateTime', function () {
            return $this->format('M d, Y g:i A'); // Jan 01, 2023 3:30 PM
        });

        Carbon::macro('toHumanDateFull', function () {
            return $this->format('l, F d, Y'); // Monday, January 01, 2023
        });

        Carbon::macro('toHumanTime', function () {
            return $this->format('g:i A'); // 3:30 PM
        });
    }
}
