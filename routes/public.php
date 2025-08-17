<?php

use App\Http\Controllers\BeachEventController;
use App\Http\Controllers\FerryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ThemeParkController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/map', [HomeController::class, 'map'])->name('map');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

// Public hotel browsing
Route::get('/hotels', [HotelController::class, 'browse'])->name('hotels.browse');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])
    ->whereNumber('hotel')
    ->name('hotels.show');

// Public beach events browsing
Route::get('/beach-events', [BeachEventController::class, 'index'])->name('beach-events.index');
Route::get('/beach-events/{event}', [BeachEventController::class, 'show'])
    ->whereNumber('event')
    ->name('beach-events.show');

// Public theme park browsing
Route::get('/theme-park', [ThemeParkController::class, 'index'])->name('theme-park.index');
Route::get('/theme-park/activities/{activity}', [ThemeParkController::class, 'showActivity'])
    ->whereNumber('activity')
    ->name('theme-park.activities.show');

// Public ferry schedules
Route::get('/ferry/schedules', [FerryController::class, 'schedules'])->name('ferry.schedules');
