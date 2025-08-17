<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public + domain routes
require __DIR__.'/public.php';

// Authenticated shared routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - redirects based on role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role-based modules
require __DIR__.'/visitor.php';
require __DIR__.'/hotel_operator.php';
require __DIR__.'/ferry_operator.php';
require __DIR__.'/park_operator.php';
require __DIR__.'/beach_organizer.php';
require __DIR__.'/admin.php';

require __DIR__.'/auth.php';
