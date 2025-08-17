<?php

use App\Http\Controllers\FerryController;
use Illuminate\Support\Facades\Route;

// Ferry Operator routes
Route::middleware(['auth', 'verified', 'role:ferry_operator,admin'])
    ->prefix('operator')
    ->group(function () {
        Route::get('/ferry', [FerryController::class, 'index'])->name('ferry.index');
        Route::get('/ferry/schedules/create', [FerryController::class, 'createSchedule'])->name('ferry.create-schedule');
        Route::post('/ferry/schedules', [FerryController::class, 'storeSchedule'])->name('ferry.store-schedule');
        Route::get('/ferry/schedules/{schedule}/edit', [FerryController::class, 'editSchedule'])
            ->whereNumber('schedule')
            ->name('ferry.edit-schedule');
        Route::put('/ferry/schedules/{schedule}', [FerryController::class, 'updateSchedule'])
            ->whereNumber('schedule')
            ->name('ferry.update-schedule');
        Route::delete('/ferry/schedules/{schedule}', [FerryController::class, 'deleteSchedule'])
            ->whereNumber('schedule')
            ->name('ferry.delete-schedule');
        Route::post('/ferry/verify-booking', [FerryController::class, 'verifyBooking'])->name('ferry.verify-booking');
    });
