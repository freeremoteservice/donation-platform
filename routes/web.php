<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Campaign;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;


// Redirect root to login or dashboard
Route::redirect('/', '/login');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        // default user redirect
        return redirect()->route('campaigns.index');
    })->name('dashboard');

    // Admin routes protected by AdminMiddleware
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin', fn () => Inertia::render('Admin/Dashboard'))->name('admin.dashboard');
    });

    // // Admin routes, restricted by AdminMiddleware
    // Route::middleware([AdminMiddleware::class])->group(function () {
    //     Route::get('/admin', fn () => Inertia::render('Admin/Dashboard'))->name('admin.dashboard');
    //     // Add more admin routes here
    // });

    // Campaign routes
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
    Route::get('/campaigns/{campaign}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/campaigns/{campaign}', [CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');

    // Donation routes
    Route::get('/campaigns/{campaign}/donate', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/campaigns/{campaign}/donate', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/my-donations', [DonationController::class, 'mine'])->name('donations.mine');

    // Profile management (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});

require __DIR__.'/auth.php';
