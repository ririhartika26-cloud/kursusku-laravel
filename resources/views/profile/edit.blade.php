@extends('layouts.app')

@section('title', 'Profil Pengguna - KursusKu')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Profil Akun</h1>
            <p class="text-muted mb-0">Perbarui informasi nama, email, dan keamanan password Anda.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-kursusku">Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Form Edit Nama & Email -->
        <div class="col-12 col-lg-6">
            <div class="card card-kursusku h-100">
                <div class="card-header">
                    <h2 class="h5 mb-0" style="color: var(--color-dark-chocolate); font-weight: 700;">Informasi Dasar</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Hak Akses</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled readonly>
                        </div>

                        <button type="submit" class="btn btn-kursusku-primary">Simpan Perubahan Profil</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Form Ganti Password -->
        <div class="col-12 col-lg-6">
            <div class="card card-kursusku h-100">
                <div class="card-header">
                    <h2 class="h5 mb-0" style="color: var(--color-dark-chocolate); font-weight: 700;">Ubah Password</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Password Lama <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    required
                                    autocomplete="current-password"
                                >
                                <button
                                    type="button"
                                    class="btn btn-outline-kursusku toggle-password"
                                    data-target="#current_password"
                                >Tampilkan</button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    id="new_password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimal 8 karakter"
                                    required
                                    autocomplete="new-password"
                                >
                                <button
                                    type="button"
                                    class="btn btn-outline-kursusku toggle-password"
                                    data-target="#new_password"
                                >Tampilkan</button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    id="new_password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    required
                                    autocomplete="new-password"
                                >
                                <button
                                    type="button"
                                    class="btn btn-outline-kursusku toggle-password"
                                    data-target="#new_password_confirmation"
                                >Tampilkan</button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-kursusku-primary">Perbarui Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
