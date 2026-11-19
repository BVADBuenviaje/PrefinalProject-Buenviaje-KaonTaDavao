{{-- Blade Presentation --}}
@props(['rating' => 0])

<div {{ $attributes->merge(['class' => 'inline-flex items-center text-amber-500']) }}>
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= round($rating))
            <span>★</span>
        @else
            <span class="text-slate-300">★</span>
        @endif
    @endfor
</div>
