<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title')</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>
<body>
    {{-- @if(auth()->check())
        @include('partials.navbar')
    @endif --}}

    <main class="py-4">
        @yield('content')
    </main>

    <script>
        // Auto logout jika session expired
        setInterval(function() {
            fetch('/check-auth')
                .then(response => {
                    if (response.status === 401) {
                        window.location.href = '/login';
                    }
                });
        }, 300000); // Cek setiap 5 menit
    </script>
</body>
</html>
