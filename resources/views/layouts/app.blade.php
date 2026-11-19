{{-- Blade Presentation --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaon Ta! Davao Buenviaje's Food Guide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col font-sans antialiased">
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight text-slate-900 hover:text-amber-600 transition">
                Kaon Ta! Davao Buenviaje's Food Guide
            </a>
            @include('partials.nav')
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <p>&copy; {{ date('Y') }} Kaon Ta! Davao Buenviaje's Food Guide. All rights reserved.</p>
    </footer>
</body>
</html>
