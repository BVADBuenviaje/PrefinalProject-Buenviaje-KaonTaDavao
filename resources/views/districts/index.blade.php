{{-- Blade Presentation --}}
@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Districts in Davao City</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($districts as $district)
            <a href="{{ route('districts.show', $district) }}" class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm hover:border-amber-400 hover:shadow transition block">
                <h2 class="text-lg font-bold text-slate-900 mb-1">{{ $district->name }}</h2>
                <p class="text-sm text-slate-500">
                    {{ $district->eateries_count }} {{ $district->eateries_count === 1 ? 'eatery' : 'eateries' }}
                </p>
            </a>
        @endforeach
    </div>
</div>
@endsection
