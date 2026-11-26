@extends('layouts.app')

@section('title', 'Daftar User - Admin KursusKu')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--color-dark-chocolate); font-weight: 700;">Pengelolaan Akun Pengguna</h1>
            <p class="text-muted mb-0">Daftar akun Admin dan User yang terdaftar pada database KursusKu.</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-kursusku">Kembali ke Dashboard Admin</a>
        </div>
    </div>

    <div class="card card-kursusku">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-semibold" style="color: var(--color-dark-chocolate);">Daftar Pengguna</span>
            <span class="badge bg-secondary">{{ $users->count() }} Akun</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: var(--color-warm-beige); color: var(--color-dark-chocolate);">
                        <tr>
                            <th class="py-3 px-3 text-center" style="width: 60px;">No</th>
                            <th class="py-3 px-3">Nama Lengkap</th>
                            <th class="py-3 px-3">Alamat Email</th>
                            <th class="py-3 px-3 text-center" style="width: 120px;">Role</th>
                            <th class="py-3 px-3" style="width: 160px;">Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="py-3 px-3 text-center text-muted fw-semibold">{{ $loop->iteration }}</td>
                                <td class="py-3 px-3 fw-semibold" style="color: var(--color-dark-chocolate);">{{ $user->name }}</td>
                                <td class="py-3 px-3">{{ $user->email }}</td>
                                <td class="py-3 px-3 text-center">
                                    @if ($user->role === 'admin')
                                        <span class="badge rounded-pill px-3 py-1" style="background-color: var(--color-dark-chocolate); color: #FFFFFF;">Admin</span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-1" style="background-color: var(--color-warm-beige); color: var(--color-dark-chocolate);">User</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-muted small">{{ $user->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-muted">Belum ada data pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
