<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Presensi</title>

    <!-- Impor Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Impor Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Impor Google Fonts (Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Mengaplikasikan font Poppins dan style dasar */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #E0F7FA;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Kontainer utama menyerupai ponsel */
        .mobile-container {
            position: relative;
            width: 100%;
            max-width: 390px;
            height: 844px;
            max-height: 90vh;
            background-color: #89d6f3;
            border-radius: 2rem;
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.15);
            overflow: hidden;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Elemen dekoratif di latar belakang */
        .decorative-circle {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
        }
        .decorative-circle.top {
            width: 16rem;
            height: 16rem;
            top: -5rem;
            right: -5rem;
        }
        .decorative-circle.bottom {
            width: 14rem;
            height: 14rem;
            bottom: -6rem;
            left: -5rem;
        }

        /* Mengatur Navigasi Tab */
        .nav-tabs {
            border-bottom: none;
            position: relative;
            height: 4rem; /* 64px */
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 1rem 1rem 0 0 !important;
            transition: all 0.3s ease-in-out;
            position: absolute;
            width: 48%;
            height: 3.5rem; /* 56px */
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Style tab yang tidak aktif */
        .nav-tabs .nav-link:not(.active) {
            background-color: #E0E7FF;
            color: #6B7280;
            transform: scale(0.9) translateY(10px);
            z-index: 10;
        }

        /* Style tab yang aktif */
        .nav-tabs .nav-link.active {
            background-color: white;
            color: #1F2937;
            z-index: 20;
            height: 4rem; /* 64px */
        }

        #login-tab { left: 1.5rem; }

        /* Card untuk form */
        .form-card {
            border-radius: 1rem;
            margin-top: -1px; /* Agar menyatu dengan tab */
            z-index: 15;
            position: relative;
        }

        /* Animasi untuk field yang muncul/hilang */
        .field-container {
            transition: all 0.4s ease-in-out;
            max-height: 0;
            overflow: hidden;
            opacity: 0;
        }
        .field-visible {
            max-height: 100px; /* Cukup besar untuk menampung field */
            opacity: 1;
        }

        .form-control, .btn {
            border-radius: 0.5rem;
        }
        .input-group-text {
            background-color: transparent;
            border-right: none;
        }
        .form-control {
            border-left: none;
        }
        .btn-cyan {
            background-color: #22d3ee;
            border-color: #22d3ee;
            color: white;
        }
        .btn-cyan:hover {
            background-color: #06b6d4;
            border-color: #06b6d4;
            color: white;
        }

    </style>
</head>
<body>
    @if(auth()->check())
        @include('partials.navbar')
    @endif

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
    <!-- Impor Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ambil elemen-elemen DOM
        const headerSubtitle = document.getElementById('header-subtitle');
        const secondaryButton = document.getElementById('secondary-button');
        const loginTab = new bootstrap.Tab(document.getElementById('login-tab'));

        const loginTabEl = document.getElementById('login-tab');

        function updateUIForLogin() {
            headerTitle.textContent = 'Welcome back!';
            headerSubtitle.textContent = 'Lorem ipsum dolor sit amet, consectetur.';
        }

        // Event listener saat tab ditampilkan
        loginTabEl.addEventListener('shown.bs.tab', event => {
            updateUIForLogin();
        });

        // Atur state awal
        document.addEventListener('DOMContentLoaded', updateUIForLogin);
    </script>
</body>
</html>
