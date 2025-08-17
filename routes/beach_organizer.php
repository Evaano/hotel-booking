<?php

use App\Http\Controllers\BeachEventController;
use Illuminate\Support\Facades\Route;

// Beach Organizer routes
Route::middleware(['auth', 'verified', 'role:beach_organizer,admin'])
    ->prefix('organizer')
    ->group(function () {
        Route::get('/beach-events/manage', [BeachEventController::class, 'manage'])->name('beach-events.manage');
        Route::get('/beach-events/create', [BeachEventController::class, 'create'])->name('beach-events.create');
        Route::get('/beach-events/bookings', [BeachEventController::class, 'manageBookings'])->name('beach-events.manage-bookings');

        Route::post('/beach-events', [BeachEventController::class, 'store'])->name('beach-events.store');
        Route::get('/beach-events/{event}/edit', [BeachEventController::class, 'edit'])
            ->whereNumber('event')
            ->name('beach-events.edit');
        Route::put('/beach-events/{event}', [BeachEventController::class, 'update'])
            ->whereNumber('event')
            ->name('beach-events.update');
        Route::delete('/beach-events/{event}', [BeachEventController::class, 'destroy'])
            ->whereNumber('event')
            ->name('beach-events.destroy');
        Route::get('/beach-events/{event}/participants', [BeachEventController::class, 'participants'])
            ->whereNumber('event')
            ->name('beach-events.event-participants');
        Route::put('/beach-events/bookings/{booking}/status', [BeachEventController::class, 'updateBookingStatus'])
            ->whereNumber('booking')
            ->name('beach-events.update-booking-status');
    });
