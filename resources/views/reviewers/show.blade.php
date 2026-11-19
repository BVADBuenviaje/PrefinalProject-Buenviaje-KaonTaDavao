{{-- Blade Presentation --}}
@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h1>
        <p class="text-sm font-medium text-slate-500 mt-1">
            {{ $reviewsCount }} {{ $reviewsCount === 1 ? 'review' : 'reviews' }} written
        </p>
    </div>

    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900">Reviews History</h2>

        @if ($user->reviews->isEmpty())
            <div class="bg-white rounded-lg border border-slate-200 p-12 text-center text-slate-500">
                <p class="text-base font-medium">No reviews written yet.</p>
            </div>
        @else
            @foreach ($user->reviews as $review)
                <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm space-y-2">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                        <h3 class="font-semibold text-base text-slate-900">
                            <a href="{{ route('eateries.show', $review->eatery) }}" class="hover:text-amber-600 transition">
                                {{ $review->eatery->name }}
                            </a>
                        </h3>
                        <span class="text-xs text-slate-400">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>

                    <div>
                        <x-rating :rating="$review->rating" />
                    </div>

                    <p class="text-sm text-slate-700 leading-relaxed pt-1">
                        {{ $review->body }}
                    </p>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
