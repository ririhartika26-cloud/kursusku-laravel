@extends('layouts.app')

@section('title', 'Login - KursusKu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card card-kursusku">
                <div class="card-header">
                    <h1 class="h4 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Masuk ke KursusKu</h1>
                    <p class="text-muted small mb-0">Gunakan akun terdaftar Anda untuk mengakses dashboard dan profil.</p>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.attempt') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="nama@kursusku.test"
                                required
                                autofocus
                                autocomplete="email"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password"
                                    required
                                    autocomplete="current-password"
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

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    value="1"
                                    @checked(old('remember'))
                                >
                                <label class="form-check-label small" for="remember">
                                    Ingat saya (Remember Me)
                                </label>
                            </div>
                            <a href="{{ route('password.request') }}" class="small fw-semibold">
                                Lupa Password?
                            </a>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-kursusku-primary">Masuk</button>
                            <a href="{{ route('home') }}" class="btn btn-outline-kursusku">Kembali ke Beranda</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
