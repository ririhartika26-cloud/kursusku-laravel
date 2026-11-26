@extends('layouts.app')

@section('title', 'Reset Password - KursusKu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card card-kursusku">
                <div class="card-header">
                    <h1 class="h4 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Atur Password Baru</h1>
                    <p class="text-muted small mb-0">Masukkan email dan password baru untuk akun Anda.</p>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                                autocomplete="email"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimal 8 karakter"
                                    required
                                    autocomplete="new-password"
                                >
                                <button
                                    type="button"
                                    class="btn btn-outline-kursusku toggle-password"
                                    data-target="#password"
                                >Tampilkan</button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password baru"
                                    required
                                    autocomplete="new-password"
                                >
                                <button
                                    type="button"
                                    class="btn btn-outline-kursusku toggle-password"
                                    data-target="#password_confirmation"
                                >Tampilkan</button>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-kursusku-primary">Simpan Password Baru</button>
                            <a href="{{ route('login') }}" class="btn btn-outline-kursusku">Kembali ke Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
