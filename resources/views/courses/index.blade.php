@extends('layouts.app')

@section('title', 'Daftar Kursus - KursusKu')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Daftar Kursus</h1>
            <p class="text-muted mb-0">Kelola dan pantau seluruh program kursus yang tersimpan di sistem.</p>
        </div>
        <div>
            <a href="{{ route('courses.create') }}" class="btn btn-kursusku-primary d-inline-flex align-items-center gap-2">
                <span>+ Tambah Kursus</span>
            </a>
        </div>
    </div>

    <div class="card card-kursusku">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: var(--color-warm-beige); color: var(--color-dark-chocolate);">
                        <tr>
                            <th scope="col" class="py-3 px-3 text-center" style="width: 50px;">No</th>
                            <th scope="col" class="py-3 px-3" style="width: 110px;">Kode</th>
                            <th scope="col" class="py-3 px-3">Nama Kursus</th>
                            <th scope="col" class="py-3 px-3" style="width: 140px;">Biaya</th>
                            <th scope="col" class="py-3 px-3 text-center" style="width: 90px;">Kuota</th>
                            <th scope="col" class="py-3 px-3" style="width: 130px;">Tanggal Mulai</th>
                            <th scope="col" class="py-3 px-3 text-center" style="width: 110px;">Status</th>
                            <th scope="col" class="py-3 px-3 text-center" style="width: 210px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $course)
                            <tr>
                                <td class="py-3 px-3 text-center text-muted fw-semibold">{{ $loop->iteration }}</td>
                                <td class="py-3 px-3">
                                    <span class="badge" style="background-color: var(--color-warm-beige); color: var(--color-dark-chocolate); font-weight: 700; font-size: 0.8rem; letter-spacing: 0.03em;">
                                        {{ $course->code }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="fw-bold" style="color: var(--color-dark-chocolate);">{{ $course->name }}</div>
                                    @if ($course->description)
                                        <small class="text-muted d-block text-truncate" style="max-width: 280px;">{{ $course->description }}</small>
                                    @endif
                                </td>
                                <td class="py-3 px-3 fw-semibold" style="color: var(--color-text-dark);">
                                    Rp {{ number_format($course->fee, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3 text-center fw-semibold">
                                    {{ $course->quota }}
                                </td>
                                <td class="py-3 px-3 text-muted">
                                    {{ $course->start_date?->format('d/m/Y') }}
                                </td>
                                <td class="py-3 px-3 text-center">
                                    @if ($course->status === 'open')
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: #E8F3EB; color: #1E5E2A; font-weight: 600;">
                                            Open
                                        </span>
                                    @elseif ($course->status === 'draft')
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: #F1ECE6; color: #64564c; border: 1px solid var(--color-border); font-weight: 600;">
                                            Draft
                                        </span>
                                    @elseif ($course->status === 'closed')
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: #49352B; color: #FFFFFF; font-weight: 600;">
                                            Closed
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-kursusku py-1 px-2" title="Lihat Detail">
                                            Detail
                                        </a>
                                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-kursusku-primary py-1 px-2" title="Edit Kursus">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Hapus kursus ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Hapus Kursus">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-5 text-center">
                                    <div class="py-4">
                                        <p class="text-muted fs-5 mb-2">Belum ada data kursus yang tersimpan di database.</p>
                                        <p class="text-muted small mb-3">Mulai tambahkan program kursus baru melalui formulir.</p>
                                        <a href="{{ route('courses.create') }}" class="btn btn-sm btn-kursusku-primary">
                                            + Tambah Kursus Sekarang
                                        </a>
                                    </div>
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
