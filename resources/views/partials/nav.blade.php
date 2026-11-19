{{-- Blade Presentation --}}
<nav class="flex items-center gap-6 text-sm font-medium">
    <a href="{{ route('home') }}" class="text-slate-600 hover:text-slate-900 transition">Home</a>
    <a href="{{ route('eateries.index') }}" class="text-slate-600 hover:text-slate-900 transition">Eateries</a>
    <a href="{{ route('districts.index') }}" class="text-slate-600 hover:text-slate-900 transition">Districts</a>
    <a href="{{ route('eateries.create') }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-amber-600 text-white font-medium hover:bg-amber-700 transition">
        + Add Eatery
    </a>
</nav>
