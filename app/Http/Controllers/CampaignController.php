<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Inertia\Inertia;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::query()->with('creator');

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('created_by')) {
            $query->whereHas('creator', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->created_by . '%');
            });
        }

        $campaigns = $query->latest()->paginate(10)->withQueryString()->through(function ($campaign) {
            return [
                ...$campaign->toArray(),
                'creator' => $campaign->creator ?? null,
                'category' => $campaign->category ?? '',
            ];
        });

        return Inertia::render('Campaigns/Index', [
            'campaigns' => $campaigns,
            'filters' => $request->only('title', 'category', 'status', 'created_by'),
            'categories' => Campaign::select('category')->distinct()->pluck('category'),
            'statuses' => Campaign::select('status')->distinct()->pluck('status'),
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
            'category' => 'required|string|max:255',
        ]);

        $campaign = new Campaign($validated);
        $campaign->user_id = auth()->id();
        $campaign->status = 'active';
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
            'category' => 'required|string|max:255',
            'status' => 'required|string|in:active,completed,cancelled',
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
