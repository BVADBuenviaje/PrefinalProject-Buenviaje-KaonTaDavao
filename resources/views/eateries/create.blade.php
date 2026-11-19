{{-- Blade Presentation --}}
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Add New Eatery</h1>
        <a href="{{ route('eateries.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition">
            &larr; Cancel
        </a>
    </div>

    <form method="POST" action="{{ route('eateries.store') }}" class="bg-white p-6 rounded-lg border border-slate-200 shadow-sm space-y-6">
        @csrf

        @include('eateries._form')

        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('eateries.index') }}" class="px-4 py-2 border border-slate-300 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-md text-sm font-medium transition shadow-sm">
                Save Eatery
            </button>
        </div>
    </form>
</div>
@endsection
