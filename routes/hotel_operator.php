<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// Hotel Operator routes
Route::middleware(['auth', 'verified', 'role:hotel_operator,admin'])
    ->prefix('operator')
    ->group(function () {
        Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
        Route::get('/hotels/create', [HotelController::class, 'create'])->name('hotels.create');
        Route::post('/hotels', [HotelController::class, 'store'])->name('hotels.store');
        Route::get('/hotels/{hotel}/edit', [HotelController::class, 'edit'])
            ->whereNumber('hotel')
            ->name('hotels.edit');
        Route::put('/hotels/{hotel}', [HotelController::class, 'update'])
            ->whereNumber('hotel')
            ->name('hotels.update');
        Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy'])
            ->whereNumber('hotel')
            ->name('hotels.destroy');

        // Room management
        Route::get('/rooms', [RoomController::class, 'allRooms'])->name('rooms.index');
        Route::get('/hotels/{hotel}/rooms', [RoomController::class, 'index'])
            ->whereNumber('hotel')
            ->name('hotels.rooms.index');
        Route::get('/hotels/{hotel}/rooms/create', [RoomController::class, 'create'])
            ->whereNumber('hotel')
            ->name('hotels.rooms.create');
        Route::post('/hotels/{hotel}/rooms', [RoomController::class, 'store'])
            ->whereNumber('hotel')
            ->name('hotels.rooms.store');
        Route::get('/hotels/{hotel}/rooms/{room}', [RoomController::class, 'show'])
            ->whereNumber('hotel')
            ->whereNumber('room')
            ->name('hotels.rooms.show');
        Route::get('/hotels/{hotel}/rooms/{room}/edit', [RoomController::class, 'edit'])
            ->whereNumber('hotel')
            ->whereNumber('room')
            ->name('hotels.rooms.edit');
        Route::put('/hotels/{hotel}/rooms/{room}', [RoomController::class, 'update'])
            ->whereNumber('hotel')
            ->whereNumber('room')
            ->name('hotels.rooms.update');
        Route::delete('/hotels/{hotel}/rooms/{room}', [RoomController::class, 'destroy'])
            ->whereNumber('hotel')
            ->whereNumber('room')
            ->name('hotels.rooms.destroy');

        // Booking management
        Route::get('/bookings', [RoomBookingController::class, 'index'])->name('bookings.index');
        Route::put('/bookings/{booking}/status', [RoomBookingController::class, 'updateStatus'])
            ->whereNumber('booking')
            ->name('bookings.update-status');
    });
