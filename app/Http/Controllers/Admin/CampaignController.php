<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('creator')->get();

        return Inertia::render('Admin/Campaigns/Index', [
            'campaigns' => $campaigns,
        ]);
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $campaign->status = $request->status;
        $campaign->save();

        return redirect()->back()->with('success', 'Campaign status updated.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()->back()->with('success', 'Campaign deleted.');
    }
}
