<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Donation;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCampaigns = Campaign::count();
        $totalDonations = Donation::sum('amount');

        return Inertia::render('Admin/Dashboard', [
            'totalUsers' => $totalUsers,
            'totalCampaigns' => $totalCampaigns,
            'totalDonations' => $totalDonations,
        ]);
    }
}
