<nav class="navbar navbar-expand-lg navbar-kursusku">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span>KursusKu</span>
            <span class="brand-badge">Edukasi</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarKursusKu" aria-controls="navbarKursusKu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarKursusKu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1 gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">Daftar Kursus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('enrollments.index') ? 'active' : '' }}" href="{{ route('enrollments.index') }}">Data Enrollment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#keunggulan">Keunggulan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#katalog">Katalog Kursus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#alur">Alur Belajar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#kontak">Kontak</a>
                </li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-sm btn-kursusku-primary {{ request()->routeIs('enrollments.create') ? 'active' : '' }}" href="{{ route('enrollments.create') }}">Pendaftaran</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
