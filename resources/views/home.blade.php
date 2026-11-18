@extends('layouts.app')

@section('title', 'Beranda - ' . ($siteName ?? 'KursusKu'))

@section('content')
    <!-- Hero Section (2 Kolom Desktop, 1 Kolom Mobile) -->
    <section class="hero-section">
        <div class="container hero-grid">
            <div class="hero-content">
                <span class="hero-tagline">Belajar, Bertumbuh, Berkembang</span>
                <h1 class="hero-title">Tingkatkan Keterampilan Bersama {{ $siteName ?? 'KursusKu' }}</h1>
                <p class="hero-description">
                    Belajar, daftar, dan kelola kursus dalam satu tempat. Akses kurikulum terstruktur dan materi praktis yang disusun langsung untuk kebutuhan industri modern.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('enrollments.create') }}" class="btn btn-primary">Daftar Sekarang</a>
                    <a href="#katalog" class="btn btn-outline">Jelajahi Kursus</a>
                    <a href="#alur" class="btn btn-outline">Panduan Belajar</a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-image-wrapper">
                    <img src="{{ asset('images/hero-kursus.jpg') }}" alt="Ilustrasi Pembelajaran {{ $siteName ?? 'KursusKu' }}" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section id="keunggulan" class="section-padding features-section">
        <div class="container">
            <div class="section-header">
                <p class="section-label">Nilai Unggul</p>
                <h2 class="section-title">Mengapa Memilih {{ $siteName ?? 'KursusKu' }}?</h2>
                <p class="section-subtitle">Kami merancang setiap program pelatihan agar memberikan dampak nyata bagi perjalanan belajar Anda.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon-box">01</div>
                    <h3 class="feature-title">Kursus Terarah</h3>
                    <p class="feature-description">Kurikulum berjenjang dari tingkat dasar hingga mahir, dirancang terstruktur agar proses belajar menjadi sistematis.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-box">02</div>
                    <h3 class="feature-title">Materi Praktis</h3>
                    <p class="feature-description">Fokus pada studi kasus dunia nyata dan praktik langsung yang relevan dengan standar industri terkini.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-box">03</div>
                    <h3 class="feature-title">Fleksibel &amp; Terjangkau</h3>
                    <p class="feature-description">Kemudahan akses materi pelatihan kapan pun dan di mana pun dengan struktur biaya yang transparan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Katalog Kursus (3 Kolom Desktop, 1 Kolom Mobile) -->
    <section id="katalog" class="section-padding courses-section">
        <div class="container">
            <div class="section-header">
                <p class="section-label">Program Pilihan</p>
                <h2 class="section-title">Katalog Kursus Unggulan</h2>
                <p class="section-subtitle">Temukan materi belajar yang tepat untuk mengembangkan keahlian dan potensi karier Anda.</p>
            </div>

            <div class="courses-grid">
                @foreach ($featured as $course)
                    <article class="course-card">
                        <div class="course-card-top">
                            <span class="course-code-badge">{{ $course['code'] }}</span>
                            <h3 class="course-title">{{ $course['name'] }}</h3>
                            <p class="course-description">{{ $course['description'] }}</p>
                        </div>
                        <div class="course-card-footer">
                            <span class="course-meta">Program Intensif</span>
                            <a href="{{ route('enrollments.create') }}" class="btn btn-outline btn-sm">Daftar Kursus</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Alur Pendaftaran & Belajar -->
    <section id="alur" class="section-padding steps-section">
        <div class="container">
            <div class="section-header">
                <p class="section-label">Alur Pembelajaran</p>
                <h2 class="section-title">Langkah Mudah Memulai Belajar</h2>
                <p class="section-subtitle">Proses sederhana untuk bergabung dan memulai perjalanan edukasi bersama kami.</p>
            </div>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Pilih Kursus</h3>
                    <p class="step-description">Tentukan program belajar sesuai dengan minat dan target keahlian Anda.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Konfirmasi Program</h3>
                    <p class="step-description">Periksa silabus, materi yang diajarkan, dan jadwal kegiatan belajar.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Registrasi</h3>
                    <p class="step-description">Lakukan pendaftaran untuk mengamankan slot pada kelas yang dipilih.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h3 class="step-title">Mulai Belajar</h3>
                    <p class="step-description">Akses ruang belajar dan ikuti sesi pembelajaran bersama mentor.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Informasi & Kontak -->
    <section id="kontak" class="section-padding info-section">
        <div class="container">
            <div class="info-box">
                <h3>Hubungi Pusat Informasi {{ $siteName ?? 'KursusKu' }}</h3>
                <p>Memerlukan konsultasi mengenai pilihan kursus atau jadwal pelaksanaan kelas? Tim kami siap membantu menjawab pertanyaan Anda.</p>
                <div class="info-contact">
                    <span>Email: info@kursusku.test</span>
                    <span>Hotline: +62 812-3456-7890</span>
                </div>
            </div>
        </div>
    </section>
@endsection
