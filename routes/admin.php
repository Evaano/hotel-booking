<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Admin + reports routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Reporting and analytics routes
    Route::middleware(['role:hotel_operator,admin'])->group(function () {
        Route::get('/reports/hotel', [ReportingController::class, 'hotelOperator'])->name('reports.hotel');
    });

    Route::middleware(['role:ferry_operator,admin'])->group(function () {
        Route::get('/reports/ferry', [ReportingController::class, 'ferryOperator'])->name('reports.ferry');
    });

    Route::middleware(['role:park_operator,admin'])->group(function () {
        Route::get('/reports/theme-park', [ReportingController::class, 'themeParkOperator'])->name('reports.theme-park');
    });

    Route::middleware(['role:beach_organizer,admin'])->group(function () {
        Route::get('/reports/beach-events', [ReportingController::class, 'beachOrganizer'])->name('reports.beach-events');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/reports/system', [ReportingController::class, 'systemWide'])->name('reports.system');

        // User management routes
        Route::resource('users', UserController::class);

        // Admin booking confirmation routes
        Route::get('/admin/pending-bookings', [AdminController::class, 'pendingBookings'])->name('admin.pending-bookings');

        // Room booking confirmation
        Route::post('/admin/room-bookings/{id}/confirm', [AdminController::class, 'confirmRoomBooking'])
            ->whereNumber('id')
            ->name('admin.room-bookings.confirm');
        Route::post('/admin/room-bookings/{id}/reject', [AdminController::class, 'rejectRoomBooking'])
            ->whereNumber('id')
            ->name('admin.room-bookings.reject');

        // Ferry ticket confirmation
        Route::post('/admin/ferry-tickets/{id}/confirm', [AdminController::class, 'confirmFerryTicket'])
            ->whereNumber('id')
            ->name('admin.ferry-tickets.confirm');
        Route::post('/admin/ferry-tickets/{id}/reject', [AdminController::class, 'rejectFerryTicket'])
            ->whereNumber('id')
            ->name('admin.ferry-tickets.reject');

        // Theme park ticket confirmation
        Route::post('/admin/park-tickets/{id}/confirm', [AdminController::class, 'confirmParkTicket'])
            ->whereNumber('id')
            ->name('admin.park-tickets.confirm');
        Route::post('/admin/park-tickets/{id}/reject', [AdminController::class, 'rejectParkTicket'])
            ->whereNumber('id')
            ->name('admin.park-tickets.reject');

        // Beach event booking confirmation
        Route::post('/admin/beach-bookings/{id}/confirm', [AdminController::class, 'confirmBeachBooking'])
            ->whereNumber('id')
            ->name('admin.beach-bookings.confirm');
        Route::post('/admin/beach-bookings/{id}/reject', [AdminController::class, 'rejectBeachBooking'])
            ->whereNumber('id')
            ->name('admin.beach-bookings.reject');
    });

    // API endpoints for booking verification (for all operators)
    Route::post('/api/verify-hotel-booking', [RoomBookingController::class, 'verify'])->name('api.verify-hotel-booking');

    // Export routes (for all operators)
    Route::get('/reports/export/{type}', [ReportingController::class, 'export'])->name('reports.export');
});
