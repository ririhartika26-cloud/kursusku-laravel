@extends('layouts.app')

@section('title', 'Lupa Password - KursusKu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card card-kursusku">
                <div class="card-header">
                    <h1 class="h4 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Lupa Password</h1>
                    <p class="text-muted small mb-0">Masukkan alamat email terdaftar untuk membuat tautan reset password.</p>
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

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Alamat Email Terdaftar <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="nama@kursusku.test"
                                required
                                autofocus
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-kursusku-primary">Kirim Tautan Reset Password</button>
                            <a href="{{ route('login') }}" class="btn btn-outline-kursusku">Kembali ke Halaman Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
