<?php

namespace App\Http\Controllers;

// Controller

use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;

class EateryController extends Controller
{
    public function index(Request $request)
    {
        $query = Eatery::with(['district', 'features'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($request->filled('q')) {
            $searchTerm = $request->query('q');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('specialty', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('district')) {
            $query->where('district_id', $request->query('district'));
        }

        if ($request->filled('feature')) {
            $featureName = $request->query('feature');
            $query->whereHas('features', function ($q) use ($featureName) {
                $q->where('name', $featureName);
            });
        }

        $eateries = $query->orderBy('name')->paginate(6)->withQueryString();
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact('eateries', 'districts', 'features'));
    }

    public function create()
    {
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact('districts', 'features'));
    }

    public function store(Request $request)
    {
        return redirect()->route('eateries.index');
    }

    public function show(Eatery $eatery)
    {
        $eatery->load([
            'district',
            'features',
            'permit',
            'dishes' => fn ($q) => $q->orderBy('name'),
            'reviews' => fn ($q) => $q->latest()->with('user'),
        ]);

        $users = User::orderBy('name')->get();

        return view('eateries.show', compact('eatery', 'users'));
    }

    public function edit(Eatery $eatery)
    {
        $eatery->load(['district', 'features', 'permit']);
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact('eatery', 'districts', 'features'));
    }

    public function update(Request $request, Eatery $eatery)
    {
        return redirect()->route('eateries.show', $eatery);
    }

    public function destroy(Eatery $eatery)
    {
        $eatery->permit()->delete();
        $eatery->dishes()->delete();
        $eatery->reviews()->delete();
        $eatery->features()->detach();
        $eatery->delete();

        return redirect()->route('eateries.index')->with('success', 'Eatery deleted.');
    }
}
