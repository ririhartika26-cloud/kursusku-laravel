@extends('layouts.app')

@section('title', 'Tambah Kursus - KursusKu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card card-kursusku">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h4 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Tambah Kursus Baru</h2>
                        <p class="text-muted small mb-0">Lengkapi data kursus di bawah ini untuk menyimpan ke database.</p>
                    </div>
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-kursusku">
                        Kembali ke Daftar
                    </a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <strong class="d-block mb-1">Terdapat kesalahan pada formulir:</strong>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('courses.store') }}">
                        @csrf

                        <!-- Kode & Nama Kursus (2 Kolom) -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="code" class="form-label fw-semibold">Kode Kursus <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="code"
                                    name="code"
                                    value="{{ old('code') }}"
                                    maxlength="20"
                                    class="form-control @error('code') is-invalid @enderror"
                                    placeholder="Contoh: WEB-101"
                                    required
                                >
                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label for="name" class="form-label fw-semibold">Nama Kursus <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    maxlength="120"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Contoh: Web Dasar"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Deskripsi Kursus</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Jelaskan ringkasan materi atau tujuan kursus ini..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Biaya & Kuota (2 Kolom) -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="fee" class="form-label fw-semibold">Biaya (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: var(--color-warm-beige); border-color: var(--color-border); color: var(--color-dark-chocolate); font-weight: 600;">Rp</span>
                                    <input
                                        type="number"
                                        id="fee"
                                        name="fee"
                                        value="{{ old('fee', 0) }}"
                                        min="0"
                                        class="form-control @error('fee') is-invalid @enderror"
                                        required
                                    >
                                </div>
                                @error('fee')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="quota" class="form-label fw-semibold">Kuota Peserta <span class="text-danger">*</span></label>
                                <input
                                    type="number"
                                    id="quota"
                                    name="quota"
                                    value="{{ old('quota', 20) }}"
                                    min="1"
                                    max="500"
                                    class="form-control @error('quota') is-invalid @enderror"
                                    required
                                >
                                @error('quota')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Mulai & Status (2 Kolom) -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input
                                    type="date"
                                    id="start_date"
                                    name="start_date"
                                    value="{{ old('start_date') }}"
                                    class="form-control @error('start_date') is-invalid @enderror"
                                    required
                                >
                                @error('start_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Status Kursus <span class="text-danger">*</span></label>
                                <select
                                    id="status"
                                    name="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    required
                                >
                                    <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option>
                                    <option value="open" @selected(old('status') === 'open')>Open</option>
                                    <option value="closed" @selected(old('status') === 'closed')>Closed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: var(--color-warm-beige) !important;">
                            <a href="{{ route('courses.index') }}" class="btn btn-outline-kursusku">Batal</a>
                            <button type="submit" class="btn btn-kursusku-primary">Simpan Kursus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
