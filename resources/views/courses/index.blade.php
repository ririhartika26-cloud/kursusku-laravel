@extends('layouts.app')

@section('title', 'Daftar Kursus - KursusKu')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Daftar Kursus</h1>
            <p class="text-muted mb-0">
                @if (auth()->check() && auth()->user()->isAdmin())
                    Kelola, cari, dan pantau seluruh program kursus yang tersimpan di sistem.
                @else
                    Jelajahi, cari, dan lihat detail program kursus yang tersedia di KursusKu.
                @endif
            </p>
        </div>
        @if (auth()->check() && auth()->user()->isAdmin())
            <div>
                <a href="{{ route('courses.create') }}" class="btn btn-kursusku-primary d-inline-flex align-items-center gap-2">
                    <span>+ Tambah Kursus</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Form Search & Filter (GET) -->
    <div class="card card-kursusku mb-4">
        <div class="card-body py-3">
            <form id="course-filter-form" method="GET" action="{{ route('courses.index') }}" class="row g-2 align-items-end">
                <div class="col-12 col-md-5">
                    <label for="q" class="form-label small fw-semibold mb-1" style="color: var(--color-dark-chocolate);">Cari Kursus</label>
                    <input
                        type="text"
                        id="q"
                        name="q"
                        value="{{ $q ?? '' }}"
                        class="form-control"
                        placeholder="Cari berdasarkan kode atau nama kursus..."
                        autocomplete="off"
                    >
                </div>
                <div class="col-12 col-md-3">
                    <label for="status" class="form-label small fw-semibold mb-1" style="color: var(--color-dark-chocolate);">Filter Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="open" @selected(($status ?? '') === 'open')>Open</option>
                        <option value="closed" @selected(($status ?? '') === 'closed')>Closed</option>
                        <option value="draft" @selected(($status ?? '') === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-kursusku-primary flex-grow-1">Cari</button>
                    <a href="{{ route('courses.index') }}" id="course-filter-reset" class="btn btn-outline-kursusku">Reset</a>
                </div>
            </form>
            <div id="course-search-feedback" class="small text-muted mt-2 d-none">Memuat hasil pencarian...</div>
        </div>
    </div>

    <div id="course-results">
        @include('courses._table', ['courses' => $courses, 'q' => $q ?? '', 'status' => $status ?? null])
    </div>
</div>
@endsection
