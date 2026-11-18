<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'KursusKu - Platform Kursus & Pelatihan Terarah')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    @include('partials.navbar')

    <main>
        @if (session('success'))
            <div class="container pt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-content">
            <p>&copy; {{ date('Y') }} KursusKu. Semua hak dilindungi. Platform Edukasi &amp; Pelatihan Terpadu.</p>
        </div>
    </footer>

</body>
</html>
