@extends('layouts.app')

@section('title', 'Dashboard Admin - KursusKu')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--color-dark-chocolate); color: #FFFFFF;">Panel Administrator</span>
            <h1 class="h3 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Dashboard Administratif</h1>
            <p class="text-muted mb-0">Kelola data kursus, akun pengguna, dan pantau operasional KursusKu.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('courses.create') }}" class="btn btn-kursusku-primary">+ Tambah Kursus</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-kursusku">Kelola User</a>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-kursusku">Profil Admin</a>
        </div>
    </div>

    <div class="row g-3 mb-4 text-center">
        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3 bg-white" style="border: 1px solid var(--color-border);">
                <div class="h3 fw-bold mb-1" style="color: var(--color-dark-chocolate);">{{ $stats['totalCourses'] }}</div>
                <div class="small text-muted fw-semibold">Total Course</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3 bg-white" style="border: 1px solid var(--color-border);">
                <div class="h3 fw-bold mb-1" style="color: #1E5E2A;">{{ $stats['openCourses'] }}</div>
                <div class="small text-muted fw-semibold">Open ({{ $stats['closedCourses'] }} Closed, {{ $stats['draftCourses'] }} Draft)</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3 bg-white" style="border: 1px solid var(--color-border);">
                <div class="h3 fw-bold mb-1" style="color: var(--color-primary-brown);">{{ $stats['totalUsers'] }}</div>
                <div class="small text-muted fw-semibold">Akun Pengguna</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3 bg-white" style="border: 1px solid var(--color-border);">
                <div class="h3 fw-bold mb-1" style="color: var(--color-medium-brown);">{{ $stats['totalEnrollments'] }}</div>
                <div class="small text-muted fw-semibold">Total Enrollment ({{ $stats['totalParticipants'] }} Peserta)</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-5">
            <div class="card card-kursusku h-100">
                <div class="card-header">
                    <span class="fw-semibold" style="color: var(--color-dark-chocolate);">Informasi Administrator</span>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted">Nama</dt>
                        <dd class="col-sm-8 fw-semibold" style="color: var(--color-dark-chocolate);">{{ $user->name }}</dd>
                        <dt class="col-sm-4 text-muted">Email</dt>
                        <dd class="col-sm-8">{{ $user->email }}</dd>
                        <dt class="col-sm-4 text-muted">Role</dt>
                        <dd class="col-sm-8 text-uppercase fw-semibold">{{ $user->role }}</dd>
                    </dl>
                </div>
                <div class="card-footer bg-white border-top">
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-kursusku">Ubah Profil Sendiri &rarr;</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="card card-kursusku h-100">
                <div class="card-header">
                    <span class="fw-semibold" style="color: var(--color-dark-chocolate);">Menu Pengelolaan Cepat</span>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                        <div>
                            <div class="fw-semibold" style="color: var(--color-dark-chocolate);">Pengelolaan Course</div>
                            <small class="text-muted">Tambah, ubah, atur status, atau hapus program kursus.</small>
                        </div>
                        <a href="{{ route('courses.index') }}" class="btn btn-sm btn-kursusku-primary">Kelola Course</a>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                        <div>
                            <div class="fw-semibold" style="color: var(--color-dark-chocolate);">Pengelolaan Akun User</div>
                            <small class="text-muted">Lihat daftar akun Admin dan User terdaftar.</small>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-kursusku">Daftar User</a>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold" style="color: var(--color-dark-chocolate);">Data Enrollment</div>
                            <small class="text-muted">Pantau seluruh pendaftaran peserta pada program kursus.</small>
                        </div>
                        <a href="{{ route('enrollments.index') }}" class="btn btn-sm btn-outline-kursusku">Lihat Enrollment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
