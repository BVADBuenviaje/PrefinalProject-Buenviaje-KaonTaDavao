{{-- Blade Presentation --}}
@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">{{ $district->name }}</h1>
            <p class="text-sm font-medium text-slate-500 mt-1">
                {{ $reviewsCount }} {{ $reviewsCount === 1 ? 'review' : 'reviews' }} in {{ $district->name }}
            </p>
        </div>
        <a href="{{ route('districts.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 transition">
            &larr; Back to all districts
        </a>
    </div>

    @if ($district->eateries->isEmpty())
        <div class="bg-white rounded-lg border border-slate-200 p-12 text-center text-slate-500">
            <p class="text-base font-medium">No eateries listed in {{ $district->name }} yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($district->eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
</div>
@endsection
