<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Campaign;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;


Route::get('/', function () {
    return redirect('/campaigns');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Campaign listing
    Route::get('/campaigns', fn () =>
        Inertia::render('CampaignList', [
            // 'campaigns' => Campaign::all() // Enable when Campaign model is ready
        ])
    )->name('campaigns.index');

    // Campaign detail
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

    // My donations
    Route::get('/my-donations', fn () =>
        Inertia::render('MyDonations', [
            // 'donations' => auth()->user()->donations // Enable when Donation model is ready
        ])
    )->name('donations.mine');

    // Breeze: Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware([
        'auth',
        AdminMiddleware::class,
    ])->group(function () {
        Route::get('/admin', fn () =>
            Inertia::render('Admin/Dashboard')
        )->name('admin.dashboard');
    });
});

require __DIR__.'/auth.php';
