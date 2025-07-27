<?php

use Illuminate\Foundation\Application;
use App\Models\Campaign;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;

// Already in your file:
// use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Breeze profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Show list of all campaigns
    Route::get('/campaigns', fn () =>
        Inertia::render('CampaignList', [
            // 'campaigns' => Campaign::all() // enable after model is ready
        ])
    )->name('campaigns.index');

    // Campaign detail view
    Route::get('/campaigns/{id}', function ($id) {
        return Inertia::render('CampaignDetail', [
            'id' => $id,
            'campaign' => Campaign::findOrFail($id),
        ]);
    })->name('campaigns.show');

    // Donation form for a campaign
    Route::get('/campaigns/{id}/donate', function ($id) {
        return Inertia::render('DonationForm', [
            'id' => $id,
            'campaign' => Campaign::findOrFail($id),
        ]);
    })->name('donations.create');

    // Authenticated user's donations
    Route::get('/my-donations', fn () =>
        Inertia::render('MyDonations', [
            // 'donations' => auth()->user()->donations // enable after model is ready
        ])
    )->name('donations.mine');
});

require __DIR__.'/auth.php';
