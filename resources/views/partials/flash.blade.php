{{-- Blade Presentation --}}
@if (session('success'))
    <div class="mb-6 p-4 rounded-md border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif
