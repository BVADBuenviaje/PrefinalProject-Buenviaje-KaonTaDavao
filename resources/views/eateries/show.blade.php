{{-- Blade Presentation --}}
@extends('layouts.app')

@section('content')
<div class="space-y-8">
    {{-- Top Action / Header --}}
    <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h1 class="text-3xl font-bold text-slate-900">{{ $eatery->name }}</h1>
                    @if (! $eatery->is_open)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                            Closed
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                            Open
                        </span>
                    @endif
                </div>

                <div class="flex items-center gap-3 text-sm text-slate-500 mb-4">
                    <a href="{{ route('districts.show', $eatery->district) }}" class="font-medium text-slate-700 hover:text-amber-600 transition">
                        {{ $eatery->district->name }}
                    </a>
                    <span>•</span>
                    <span class="font-semibold text-amber-700">
                        {{ $eatery->price_range === 'budget' ? '₱' : ($eatery->price_range === 'mid' ? '₱₱' : '₱₱₱') }}
                    </span>
                    <span>•</span>
                    <span>{{ $eatery->address }}</span>
                </div>

                @if ($eatery->specialty)
                    <p class="text-sm text-slate-700 mb-3">
                        <strong class="font-semibold text-slate-900">House Specialty:</strong> {{ $eatery->specialty }}
                    </p>
                @endif

                @if ($eatery->features->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($eatery->features as $feature)
                            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                                {{ $feature->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-3 self-start">
                <a href="{{ route('eateries.edit', $eatery) }}" class="px-4 py-2 rounded-md border border-slate-300 text-slate-700 text-sm font-medium hover:bg-slate-50 transition">
                    Edit Eatery
                </a>
                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}" onsubmit="return confirm('Are you sure you want to delete this eatery?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-md bg-rose-600 text-white text-sm font-medium hover:bg-rose-700 transition">
                        Delete Eatery
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Permit Box --}}
    @if ($eatery->permit)
        <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
            <h2 class="text-base font-bold text-slate-900 mb-2">Business Permit</h2>
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6 text-sm text-slate-600">
                <div>
                    <span class="text-slate-400 font-medium">Permit Number:</span>
                    <span class="font-semibold text-slate-800 ml-1">{{ $eatery->permit->permit_no }}</span>
                </div>
                <div>
                    <span class="text-slate-400 font-medium">Expires On:</span>
                    <span class="font-semibold text-slate-800 ml-1">{{ $eatery->permit->expires_on->format('F d, Y') }}</span>
                </div>
                @if ($eatery->permit->expires_on->isPast())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-rose-100 text-rose-700">
                        Permit expired
                    </span>
                @endif
            </div>
        </div>
    @endif

    {{-- Dishes Menu --}}
    <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Menu & Dishes</h2>
        @if ($eatery->dishes->isEmpty())
            <p class="text-sm text-slate-500 italic">No dishes listed yet.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($eatery->dishes as $dish)
                    <div class="border border-slate-200 rounded-lg p-4 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-medium text-slate-900 text-sm">{{ $dish->name }}</h3>
                                @if ($dish->is_bestseller)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-100 text-amber-800">
                                        Bestseller
                                    </span>
                                @endif
                            </div>
                        </div>
                        <span class="font-bold text-slate-800 text-sm">₱{{ number_format($dish->price, 2) }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Reviews Section --}}
    <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h2 class="text-lg font-bold text-slate-900">
                Reviews ({{ $eatery->reviews->count() }})
            </h2>
            @if ($eatery->reviews->isNotEmpty())
                <div class="flex items-center gap-2">
                    <span class="text-xl font-bold text-slate-900">{{ number_format($eatery->reviews->avg('rating'), 1) }}</span>
                    <x-rating :rating="$eatery->reviews->avg('rating')" />
                </div>
            @endif
        </div>

        {{-- Review Form or Closed notice --}}
        @if (! $eatery->is_open)
            <div class="p-4 rounded-md border border-slate-200 bg-slate-50 text-slate-600 text-sm italic">
                This eatery is closed. Reviews are paused.
            </div>
        @else
            <div class="bg-slate-50 rounded-lg p-5 border border-slate-200">
                <h3 class="font-semibold text-sm text-slate-900 mb-3">Leave a Review</h3>

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-md bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="user_id" class="block text-xs font-semibold text-slate-700 mb-1">Reviewer</label>
                            <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm bg-white focus:outline-none focus:ring-1 focus:ring-amber-500">
                                <option value="">Choose who is writing this review</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="rating" class="block text-xs font-semibold text-slate-700 mb-1">Rating</label>
                            <select name="rating" id="rating" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm bg-white focus:outline-none focus:ring-1 focus:ring-amber-500">
                                <option value="">Select rating (1-5 stars)</option>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }} {{ $i === 1 ? 'Star' : 'Stars' }}</option>
                                @endfor
                            </select>
                            @error('rating')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="body" class="block text-xs font-semibold text-slate-700 mb-1">Review</label>
                        <textarea name="body" id="body" rows="3" placeholder="Share your experience (at least 10 characters)..." class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-amber-500">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="px-4 py-2 rounded-md bg-amber-600 text-white font-medium text-sm hover:bg-amber-700 transition">
                        Post Review
                    </button>
                </form>
            </div>
        @endif

        {{-- Reviews List --}}
        @if ($eatery->reviews->isEmpty())
            <p class="text-sm text-slate-400 italic">No reviews yet for this eatery.</p>
        @else
            <div class="space-y-4">
                @foreach ($eatery->reviews as $review)
                    <div class="border border-slate-100 rounded-lg p-4 bg-white flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="space-y-1.5 flex-1">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('reviewers.show', $review->user) }}" class="font-semibold text-sm text-slate-900 hover:text-amber-600 transition">
                                    {{ $review->user->name }}
                                </a>
                                <span class="text-xs text-slate-400">• {{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <x-rating :rating="$review->rating" />
                            </div>
                            <p class="text-sm text-slate-700 leading-relaxed pt-1">
                                {{ $review->body }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?');" class="self-start sm:self-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-medium transition">
                                Delete
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
