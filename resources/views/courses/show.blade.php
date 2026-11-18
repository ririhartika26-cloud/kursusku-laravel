@extends('layouts.app')

@section('title', 'Detail Kursus - ' . $course->name)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card card-kursusku">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge" style="background-color: var(--color-warm-beige); color: var(--color-dark-chocolate); font-weight: 700; font-size: 0.85rem; letter-spacing: 0.04em;">
                            {{ $course->code }}
                        </span>
                        <h1 class="h4 mt-2 mb-0" style="color: var(--color-dark-chocolate); font-weight: 700;">{{ $course->name }}</h1>
                    </div>
                    <div>
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
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted fw-bold small" style="letter-spacing: 0.05em;">Deskripsi Program</h6>
                        <p class="fs-6 text-secondary mb-0" style="line-height: 1.7;">
                            {{ $course->description ?: 'Tidak ada deskripsi untuk kursus ini.' }}
                        </p>
                    </div>

                    <div class="row g-3 py-3 border-top border-bottom" style="border-color: var(--color-warm-beige) !important;">
                        <div class="col-sm-4">
                            <span class="text-muted small d-block mb-1">Biaya Kursus</span>
                            <span class="fw-bold fs-5" style="color: var(--color-dark-chocolate);">
                                Rp {{ number_format($course->fee, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted small d-block mb-1">Kapasitas Kuota</span>
                            <span class="fw-bold fs-5" style="color: var(--color-dark-chocolate);">
                                {{ $course->quota }} <small class="text-muted fs-6 fw-normal">peserta</small>
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted small d-block mb-1">Tanggal Mulai</span>
                            <span class="fw-bold fs-5" style="color: var(--color-dark-chocolate);">
                                {{ $course->start_date?->format('d-m-Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-kursusku">
                            &larr; Kembali ke Daftar
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('courses.edit', $course) }}" class="btn btn-kursusku-primary">
                                Edit Kursus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
