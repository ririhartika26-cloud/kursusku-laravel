@extends('layouts.app')

@section('title', 'Pendaftaran Kursus - KursusKu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-7">
            <div class="card card-kursusku">
                <div class="card-header">
                    <h2 class="h4 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Form Pendaftaran Kursus</h2>
                    <p class="text-muted small mb-0">Hubungkan data peserta dengan program kursus yang tersedia pada sistem KursusKu.</p>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <strong class="d-block mb-1">Terjadi kesalahan pada input data:</strong>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('enrollments.store') }}" method="POST">
                        @csrf

                        <!-- Pilihan Peserta (Relasi Participant) -->
                        <div class="mb-3">
                            <label for="participant_id" class="form-label fw-semibold">Pilih Peserta <span class="text-danger">*</span></label>
                            <select
                                id="participant_id"
                                name="participant_id"
                                class="form-select @error('participant_id') is-invalid @enderror"
                                required
                            >
                                <option value="">-- Pilih Peserta Terdaftar --</option>
                                @foreach ($participants as $participant)
                                    <option value="{{ $participant->id }}" @selected(old('participant_id') == $participant->id)>
                                        {{ $participant->name }} ({{ $participant->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('participant_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">Peserta diambil langsung dari entitas relasional participants.</div>
                        </div>

                        <!-- Pilihan Kursus (Relasi Course) -->
                        <div class="mb-3">
                            <label for="course_id" class="form-label fw-semibold">Pilihan Kursus <span class="text-danger">*</span></label>
                            <select
                                id="course_id"
                                name="course_id"
                                class="form-select @error('course_id') is-invalid @enderror"
                                required
                            >
                                <option value="">-- Pilih Kursus yang Dibuka --</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                                        {{ $course->code }} - {{ $course->name }} (Rp {{ number_format($course->fee, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">Hanya kursus dengan status terbuka (open) yang ditampilkan.</div>
                        </div>

                        <!-- Area Availability (Ajax MySQL) -->
                        <div class="mb-4">
                            <div id="availability" class="alert alert-secondary mb-0">
                                Pilih kursus untuk melihat informasi kuota dan status kursus.
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('enrollments.index') }}" class="btn btn-outline-kursusku">Lihat Data Enrollment</a>
                            <button type="submit" class="btn btn-kursusku-primary">Simpan Pendaftaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
