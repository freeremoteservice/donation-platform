<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    public function create(Campaign $campaign)
    {
        return Inertia::render('Donations/Create', [
            'campaign' => $campaign,
        ]);
    }

    public function store(Request $request, Campaign $campaign)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        Donation::create([
            'user_id' => $request->user()->id,
            'campaign_id' => $campaign->id,
            'amount' => $request->input('amount'),
        ]);

        return redirect()->route('donations.mine')->with('success', 'Donation submitted.');
    }

    public function mine()
    {
        $donations = Donation::with('campaign')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return Inertia::render('Donations/Mine', [
            'donations' => $donations,
        ]);
    }
}
