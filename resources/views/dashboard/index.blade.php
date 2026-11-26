@extends('layouts.app')

@section('title', 'Dashboard Pengguna - KursusKu')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Dashboard Pengguna</h1>
            <p class="text-muted mb-0">Informasi akun dan riwayat pendaftaran kursus Anda di KursusKu.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('profile.edit') }}" class="btn btn-kursusku-primary">Kelola Profil</a>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-kursusku">Jelajahi Course</a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Informasi Pengguna yang Sedang Login -->
        <div class="col-12 col-lg-5">
            <div class="card card-kursusku h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold" style="color: var(--color-dark-chocolate);">Informasi Akun</span>
                    <span class="badge rounded-pill px-3 py-1" style="background-color: var(--color-warm-beige); color: var(--color-dark-chocolate);">User</span>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted">Nama</dt>
                        <dd class="col-sm-8 fw-semibold" style="color: var(--color-dark-chocolate);">{{ $user->name }}</dd>

                        <dt class="col-sm-4 text-muted">Email</dt>
                        <dd class="col-sm-8">{{ $user->email }}</dd>

                        <dt class="col-sm-4 text-muted">Kursus Tersedia</dt>
                        <dd class="col-sm-8">{{ $stats['openCourses'] }} dari {{ $stats['totalCourses'] }} program</dd>

                        <dt class="col-sm-4 text-muted">Bergabung</dt>
                        <dd class="col-sm-8 mb-0">{{ $user->created_at?->format('d/m/Y') ?? '-' }}</dd>
                    </dl>
                </div>
                <div class="card-footer bg-white border-top">
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-kursusku">Ubah Profil &amp; Password &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Informasi Pendaftaran Milik User -->
        <div class="col-12 col-lg-7">
            <div class="card card-kursusku h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold" style="color: var(--color-dark-chocolate);">Pendaftaran Saya</span>
                    <span class="badge bg-secondary">{{ $stats['myEnrollmentsCount'] }} Kursus</span>
                </div>
                <div class="card-body">
                    @if ($myEnrollments->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Kursus</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myEnrollments as $enrollment)
                                        <tr>
                                            <td><span class="badge bg-light text-dark border">{{ $enrollment->course?->code }}</span></td>
                                            <td class="fw-semibold">{{ $enrollment->course?->name }}</td>
                                            <td><span class="badge bg-success">{{ ucfirst($enrollment->status) }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-3">Belum ada pendaftaran kursus yang tercatat atas email <strong>{{ $user->email }}</strong>.</p>
                        <a href="{{ route('enrollments.create') }}" class="btn btn-sm btn-kursusku-primary">Daftar Kursus Sekarang</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
