<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Inertia\Inertia;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('creator')->latest()->get();

        return Inertia::render('Campaigns/Index', [
            'campaigns' => $campaigns,
        ]);
    }

    public function create()
    {
        return Inertia::render('Campaigns/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        $campaign = new Campaign($validated);
        $campaign->user_id = auth()->id();
        $campaign->save();

        return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully.');
    }

    public function show($id)
    {
        $campaign = Campaign::with(['creator', 'donations.user'])->findOrFail($id);

        $campaign->total_donated = $campaign->donations->sum('amount');
        $campaign->donations_count = $campaign->donations->count();

        return Inertia::render('Campaigns/Show', [
            'campaign' => $campaign,
        ]);
    }

    public function edit($id)
    {
        $campaign = Campaign::findOrFail($id);

        // Optional: authorize user to edit their own campaign
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Campaigns/Edit', [
            'campaign' => $campaign,
        ]);
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        // Optional: authorize user to update their own campaign
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        $campaign->update($validated);

        return redirect()->route('campaigns.show', $campaign->id)->with('success', 'Campaign updated successfully.');
    }

    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);

        // Optional: authorize user to delete their own campaign
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }

        $campaign->delete();

        return redirect()->route('campaigns.index')->with('success', 'Campaign deleted successfully.');
    }
}
