@extends('layouts.app')

@section('title', 'Data Enrollment - KursusKu')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: var(--color-dark-chocolate);">Laporan Data Enrollment</h1>
            <p class="text-muted mb-0">Daftar relasi pendaftaran antara peserta dan program kursus yang aktif.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-kursusku">
                Kelola Kursus
            </a>
            <a href="{{ route('enrollments.create') }}" class="btn btn-kursusku-primary">
                + Tambah Enrollment
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-kursusku">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-semibold" style="color: var(--color-dark-chocolate);">Daftar Seluruh Pendaftaran</span>
            <span class="badge bg-secondary">{{ $enrollments->count() }} Pendaftaran</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 60px;">No</th>
                            <th>Peserta</th>
                            <th>Kursus</th>
                            <th>Tanggal Mulai</th>
                            <th>Biaya</th>
                            <th class="text-center">Status</th>
                            <th>Terdaftar Pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $index => $enrollment)
                            <tr>
                                <td class="text-center fw-semibold text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $enrollment->participant->name }}</div>
                                    <div class="small text-muted">{{ $enrollment->participant->email }}</div>
                                    @if ($enrollment->participant->phone)
                                        <div class="small text-muted"><i class="bi bi-telephone"></i> {{ $enrollment->participant->phone }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $enrollment->course->code }}</span>
                                    <span class="fw-semibold ms-1">{{ $enrollment->course->name }}</span>
                                </td>
                                <td>
                                    {{ $enrollment->course->start_date ? $enrollment->course->start_date->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    Rp {{ number_format($enrollment->course->fee, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if ($enrollment->status === 'registered')
                                        <span class="badge bg-success">Terdaftar</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($enrollment->status) }}</span>
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    {{ $enrollment->created_at ? $enrollment->created_at->format('d/m/Y H:i') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted mb-3">Belum ada data pendaftaran enrollment yang tersimpan.</div>
                                    <a href="{{ route('enrollments.create') }}" class="btn btn-sm btn-kursusku-primary">
                                        Tambah Enrollment Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
