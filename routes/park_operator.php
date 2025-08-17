<?php

use App\Http\Controllers\ThemeParkController;
use Illuminate\Support\Facades\Route;

// Park Operator routes
Route::middleware(['auth', 'verified', 'role:park_operator,admin'])
    ->prefix('operator')
    ->group(function () {
        Route::get('/theme-park/manage', [ThemeParkController::class, 'manage'])->name('theme-park.manage');
        Route::get('/theme-park/activities', [ThemeParkController::class, 'activities'])->name('theme-park.activities');
        Route::get('/theme-park/activities/create', [ThemeParkController::class, 'createActivity'])->name('theme-park.create-activity');
        Route::post('/theme-park/activities', [ThemeParkController::class, 'storeActivity'])->name('theme-park.store-activity');
        Route::get('/theme-park/activities/{activity}/edit', [ThemeParkController::class, 'editActivity'])
            ->whereNumber('activity')
            ->name('theme-park.edit-activity');
        Route::put('/theme-park/activities/{activity}', [ThemeParkController::class, 'updateActivity'])
            ->whereNumber('activity')
            ->name('theme-park.update-activity');
        Route::delete('/theme-park/activities/{activity}', [ThemeParkController::class, 'deleteActivity'])
            ->whereNumber('activity')
            ->name('theme-park.delete-activity');
        Route::post('/theme-park/verify-booking', [ThemeParkController::class, 'verifyBooking'])->name('theme-park.verify-booking');
    });
