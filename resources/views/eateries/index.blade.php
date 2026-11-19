{{-- Blade Presentation --}}
@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">All Eateries</h1>
            <p class="text-sm text-slate-500">Explore carinderias and food spots in Davao City</p>
        </div>
        <a href="{{ route('eateries.create') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-amber-600 text-white font-medium hover:bg-amber-700 transition self-start sm:self-auto">
            + Add New Eatery
        </a>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('eateries.index') }}" class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label for="q" class="block text-xs font-semibold text-slate-700 mb-1">Search</label>
            <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Search name or specialty..." class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-amber-500">
        </div>

        <div>
            <label for="district" class="block text-xs font-semibold text-slate-700 mb-1">District</label>
            <select name="district" id="district" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-amber-500 bg-white">
                <option value="">All Districts</option>
                @foreach ($districts as $d)
                    <option value="{{ $d->id }}" @selected(request('district') == $d->id)>{{ $d->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="feature" class="block text-xs font-semibold text-slate-700 mb-1">Feature</label>
            <select name="feature" id="feature" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-amber-500 bg-white">
                <option value="">All Features</option>
                @foreach ($features as $f)
                    <option value="{{ $f->name }}" @selected(request('feature') == $f->name)>{{ $f->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 px-4 py-2 rounded-md bg-slate-900 text-white font-medium text-sm hover:bg-slate-800 transition">
                Filter
            </button>
            @if (request()->hasAny(['q', 'district', 'feature']))
                <a href="{{ route('eateries.index') }}" class="px-3 py-2 rounded-md border border-slate-300 text-slate-700 font-medium text-sm hover:bg-slate-100 transition">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Eatery Grid --}}
    @if ($eateries->isEmpty())
        <div class="bg-white rounded-lg border border-slate-200 p-12 text-center text-slate-500">
            <p class="text-base font-medium">No eateries match your filters.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>

        {{-- Centered Circular Pagination --}}
        {{ $eateries->links('partials.pagination') }}
    @endif
</div>
@endsection
