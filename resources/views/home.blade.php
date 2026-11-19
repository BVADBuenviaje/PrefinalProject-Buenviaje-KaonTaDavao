{{-- Blade Presentation --}}
@extends('layouts.app')

@section('content')
<div class="space-y-10">
    <div class="bg-white rounded-lg border border-slate-200 p-8 shadow-sm">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Welcome to Davao's Eatery Guide</h1>
        <p class="text-slate-600 max-w-2xl mb-8">
            Discover carinderias, eateries, and local food spots across Davao City districts.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 border-t border-slate-100">
            <div class="bg-slate-50 rounded-lg p-5 border border-slate-200">
                <span class="block text-3xl font-extrabold text-slate-900">{{ $eateriesCount }}</span>
                <span class="text-sm font-medium text-slate-500">Eateries Listed</span>
            </div>
            <div class="bg-slate-50 rounded-lg p-5 border border-slate-200">
                <span class="block text-3xl font-extrabold text-slate-900">{{ $districtsCount }}</span>
                <span class="text-sm font-medium text-slate-500">Districts Covered</span>
            </div>
            <div class="bg-slate-50 rounded-lg p-5 border border-slate-200">
                <span class="block text-3xl font-extrabold text-slate-900">{{ $reviewsCount }}</span>
                <span class="text-sm font-medium text-slate-500">Community Reviews</span>
            </div>
        </div>
    </div>

    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-900">Top Rated Eateries</h2>
            <a href="{{ route('eateries.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 transition">
                View all eateries &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($topEateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    </div>
</div>
@endsection
