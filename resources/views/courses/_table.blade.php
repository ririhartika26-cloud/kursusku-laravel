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
                            <td class="py-3 px-3 text-center text-muted fw-semibold">
                                {{ $courses->firstItem() + $loop->index }}
                            </td>
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
                                    @if (auth()->check() && auth()->user()->isAdmin())
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
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-5 text-center">
                                <div class="py-4 px-3">
                                    @if (($q ?? '') !== '' || !empty($status))
                                        <p class="fw-semibold fs-5 mb-2" style="color: var(--color-dark-chocolate);">
                                            Tidak ditemukan kursus yang sesuai dengan kriteria pencarian.
                                        </p>
                                        <p class="text-muted small mb-3">
                                            @if (($q ?? '') !== '')
                                                Kata kunci: <strong>"{{ $q }}"</strong>
                                            @endif
                                            @if (($q ?? '') !== '' && !empty($status))
                                                &middot;
                                            @endif
                                            @if (!empty($status))
                                                Status: <strong>{{ ucfirst($status) }}</strong>
                                            @endif
                                        </p>
                                        <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-kursusku">
                                            Reset Pencarian &amp; Filter
                                        </a>
                                    @else
                                        <p class="text-muted fs-5 mb-2">Belum ada data kursus yang tersimpan di database.</p>
                                        <p class="text-muted small mb-3">Mulai tambahkan program kursus baru melalui formulir.</p>
                                        <a href="{{ route('courses.create') }}" class="btn btn-sm btn-kursusku-primary">
                                            + Tambah Kursus Sekarang
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($courses->hasPages() || $courses->total() > 0)
        <div class="card-footer bg-white border-top py-3 px-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div class="small text-muted">
                @if ($courses->total() > 0)
                    Menampilkan <strong>{{ $courses->firstItem() }}</strong> sampai <strong>{{ $courses->lastItem() }}</strong> dari <strong>{{ $courses->total() }}</strong> kursus
                @else
                    Menampilkan 0 kursus
                @endif
            </div>
            @if ($courses->hasPages())
                <div class="kursusku-pagination">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
