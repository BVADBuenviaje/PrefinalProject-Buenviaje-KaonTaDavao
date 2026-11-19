{{-- Blade Presentation --}}
@props(['eatery'])

@php
    $priceSymbols = [
        'budget' => '₱',
        'mid' => '₱₱',
        'splurge' => '₱₱₱',
    ];
    $priceDisplay = $priceSymbols[$eatery->price_range] ?? $eatery->price_range;
    $avgRating = $eatery->reviews_avg_rating ?? ($eatery->reviews->count() ? $eatery->reviews->avg('rating') : null);
    $reviewCount = $eatery->reviews_count ?? $eatery->reviews->count();
@endphp

<div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm hover:border-slate-300 transition flex flex-col justify-between">
    <div>
        <div class="flex items-start justify-between gap-2 mb-2">
            <h3 class="font-semibold text-lg text-slate-900 leading-snug">
                <a href="{{ route('eateries.show', $eatery) }}" class="hover:text-amber-600 transition">
                    {{ $eatery->name }}
                </a>
            </h3>
            @if (! $eatery->is_open)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-rose-100 text-rose-700">
                    Closed
                </span>
            @endif
        </div>

        <div class="flex items-center gap-2 text-xs text-slate-500 mb-3">
            <a href="{{ route('districts.show', $eatery->district) }}" class="font-medium text-slate-700 hover:text-amber-600 transition">
                {{ $eatery->district->name }}
            </a>
            <span>•</span>
            <span class="font-semibold text-amber-700">{{ $priceDisplay }}</span>
        </div>

        @if ($eatery->specialty)
            <p class="text-sm text-slate-600 mb-3">
                <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold block">Specialty</span>
                {{ $eatery->specialty }}
            </p>
        @endif

        @if ($eatery->features->isNotEmpty())
            <div class="flex flex-wrap gap-1.5 mb-4">
                @foreach ($eatery->features as $feature)
                    <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                        {{ $feature->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
        @if ($avgRating && $reviewCount > 0)
            <div class="flex items-center gap-1.5">
                <span class="font-bold text-slate-800">{{ number_format($avgRating, 1) }} ★</span>
                <span>({{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }})</span>
            </div>
        @else
            <span class="text-slate-400 italic">No reviews yet</span>
        @endif
    </div>
</div>
