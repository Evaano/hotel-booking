<?php

use App\Http\Controllers\BeachEventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FerryController;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\ThemeParkController;
use Illuminate\Support\Facades\Route;

// Visitor routes (require auth + verified + role visitor|admin)
Route::middleware(['auth', 'verified', 'role:visitor,admin'])->group(function () {
    // My Bookings hub
    Route::get('/my-bookings', [DashboardController::class, 'myBookings'])->name('my.bookings');
    Route::get('/bookings', [DashboardController::class, 'hotelBookings'])->name('hotel.bookings');

    // Hotel bookings - moved to hotel_operator.php but keeping the create/store/show/cancel/payment for visitors
    Route::get('/bookings/create', [RoomBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [RoomBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [RoomBookingController::class, 'show'])
        ->whereNumber('booking')
        ->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [RoomBookingController::class, 'cancel'])
        ->whereNumber('booking')
        ->name('bookings.cancel');
    Route::post('/bookings/{booking}/payment', [RoomBookingController::class, 'processPayment'])
        ->whereNumber('booking')
        ->name('bookings.payment');

    // Ferry tickets
    Route::get('/ferry/book-ticket', [FerryController::class, 'bookTicket'])->name('ferry.book-ticket');
    Route::post('/ferry/book-ticket', [FerryController::class, 'storeTicket'])->name('ferry.store-ticket');
    Route::get('/ferry/tickets', [FerryController::class, 'tickets'])->name('ferry.tickets');
    Route::get('/ferry/tickets/{ticket}', [FerryController::class, 'showTicket'])
        ->whereNumber('ticket')
        ->name('ferry.tickets.show');
    Route::post('/ferry/tickets/{ticket}/cancel', [FerryController::class, 'cancelTicket'])
        ->whereNumber('ticket')
        ->name('ferry.cancel-ticket');

    // Theme park tickets
    Route::get('/theme-park/book-ticket', [ThemeParkController::class, 'bookTicket'])->name('theme-park.book-ticket');
    Route::post('/theme-park/book-ticket', [ThemeParkController::class, 'storeTicket'])->name('theme-park.store-ticket');
    Route::get('/theme-park/tickets', [ThemeParkController::class, 'tickets'])->name('theme-park.tickets');
    Route::get('/theme-park/tickets/{ticket}', [ThemeParkController::class, 'showTicket'])
        ->whereNumber('ticket')
        ->name('theme-park.tickets.show');
    Route::get('/theme-park/tickets/{ticket}/activities', [ThemeParkController::class, 'ticketActivities'])
        ->whereNumber('ticket')
        ->name('theme-park.ticket.activities');
    Route::get('/theme-park/tickets/{ticket}/book-activity', [ThemeParkController::class, 'bookActivity'])
        ->whereNumber('ticket')
        ->name('theme-park.book-activity');
    Route::post('/theme-park/tickets/{ticket}/book-activity', [ThemeParkController::class, 'storeActivityBooking'])
        ->whereNumber('ticket')
        ->name('theme-park.store-activity');
    Route::post('/theme-park/activity-bookings/{booking}/cancel', [ThemeParkController::class, 'cancelActivityBooking'])
        ->whereNumber('booking')
        ->name('theme-park.cancel-activity');
    Route::post('/theme-park/tickets/{ticket}/cancel', [ThemeParkController::class, 'cancelTicket'])
        ->whereNumber('ticket')
        ->name('theme-park.cancel-ticket');

    // Beach event bookings
    Route::get('/beach-events/{event}/book', [BeachEventController::class, 'bookEvent'])
        ->whereNumber('event')
        ->name('beach-events.book');
    Route::post('/beach-events/{event}/book', [BeachEventController::class, 'storeBooking'])
        ->whereNumber('event')
        ->name('beach-events.store-booking');
    Route::get('/beach-events/bookings', [BeachEventController::class, 'bookings'])->name('beach-events.bookings');
    Route::get('/beach-events/bookings/{booking}', [BeachEventController::class, 'showBooking'])
        ->whereNumber('booking')
        ->name('beach-events.show-booking');
    Route::post('/beach-events/bookings/{booking}/cancel', [BeachEventController::class, 'cancelBooking'])
        ->whereNumber('booking')
        ->name('beach-events.cancel-booking');
});
