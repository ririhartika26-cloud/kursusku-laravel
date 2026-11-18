# Laporan Pengujian Manual — Praktikum Pertemuan 10
## Modul: Laravel Database & CRUD I — Model, Migration, Read, Insert
### Aplikasi: KursusKu Laravel (`D:\laragon\www\kursusku-laravel`)

Pengujian dilakukan secara langsung pada lingkungan lokal Laragon (Apache, MySQL 8.4.3, PHP 8.3.33) menggunakan database `kursus_riri`.

---

| No | Nama Test | Input Data | Expected Result | Actual Result | Status | Catatan Perbaikan / Temuan |
|---|---|---|---|---|---|---|
| 1 | **Simpan Data Valid** | `code: 'WEB-101'`, `name: 'Web Dasar'`, `description: 'Mempelajari dasar HTML5, CSS3...'`, `fee: 300000`, `quota: 25`, `start_date: '2026-12-01'`, `status: 'open'` | Data berhasil disimpan ke tabel `courses` di MySQL, sistem melakukan HTTP redirect 302 ke rute `courses.index`, dan menampilkan flash message sukses: *"Kursus berhasil ditambahkan."* | HTTP Status 302 Foundation Redirect ke `http://kursusku-laravel.test/courses`. Data tercatat di database MySQL `kursus_riri` dengan ID 1. Flash message sukses muncul di halaman index. | **LULUS** | Alur validasi dan `Course::create($data)` berfungsi presisi. |
| 2 | **Validasi Kode Kosong** | `code: ''` (string kosong), `name: 'Web Dasar'`, `fee: 300000`, `quota: 25`, `start_date: '2026-12-01'`, `status: 'open'` | Permintaan ditolak oleh validasi server-side Laravel pada rule `required` untuk field `code`. Data tidak disimpan ke database, sistem me-redirect kembali ke form dengan error message. | HTTP Status 302 redirect kembali ke form. Kotak error menampilkan pesan kesalahan pada field kode (`The code field is required.`) dan input lain dipertahankan via `old()`. Data tidak masuk ke MySQL. | **LULUS** | Rule `required` pada field `code` bekerja dengan benar. |
| 3 | **Validasi Kode Duplikat** | `code: 'WEB-101'` (kode yang sudah ada pada database), `name: 'Web Dasar Duplikat'`, `fee: 300000`, `quota: 25`, `start_date: '2026-12-01'`, `status: 'open'` | Permintaan ditolak oleh rule `unique:courses,code`. Tidak ada data baru yang dibuat di database, sistem mengembalikan redirect back dengan pesan error unik. | HTTP Status 302 redirect back ke form. Field `code` ditandai invalid dengan pesan `The code has already been taken.` Tidak terjadi duplikasi data di MySQL. | **LULUS** | Rule `unique:courses,code` mencegah duplikasi kode kursus. |
| 4 | **Validasi Nama Kosong** | `code: 'TES-004'`, `name: ''` (string kosong), `fee: 300000`, `quota: 25`, `start_date: '2026-12-01'`, `status: 'open'` | Permintaan ditolak oleh rule `required` pada field `name`. Data tidak disimpan ke database. | HTTP Status 302 redirect back. Pesan error validasi `The name field is required.` tampil di form. Data `TES-004` tidak masuk ke MySQL. | **LULUS** | Rule `required` pada field `name` terverifikasi aktif. |
| 5 | **Validasi Biaya Negatif** | `code: 'TES-005'`, `name: 'Kursus Biaya Negatif'`, `fee: -1000`, `quota: 25`, `start_date: '2026-12-01'`, `status: 'open'` | Permintaan ditolak oleh rule `min:0` pada field `fee`. Nilai negatif tidak diizinkan masuk ke database. | HTTP Status 302 redirect back. Input field `fee` mendapatkan pesan error `The fee field must be at least 0.` Data tidak tersimpan di database. | **LULUS** | Mencegah anomali nilai biaya kursus negatif. |
| 6 | **Validasi Kuota Nol** | `code: 'TES-006'`, `name: 'Kursus Kuota Nol'`, `fee: 300000`, `quota: 0`, `start_date: '2026-12-01'`, `status: 'open'` | Permintaan ditolak oleh rule `min:1` pada field `quota`. Kuota kelas minimal harus 1 peserta. | HTTP Status 302 redirect back. Pesan error validasi `The quota field must be at least 1.` muncul pada formulir. Data tidak disimpan ke MySQL. | **LULUS** | Menjamin setiap kursus memiliki kuota minimal 1. |
| 7 | **Validasi Status Tidak Valid** | `code: 'TES-007'`, `name: 'Kursus Status Active'`, `fee: 300000`, `quota: 25`, `start_date: '2026-12-01'`, `status: 'active'` | Permintaan ditolak oleh rule `in:draft,open,closed`. Nilai di luar daftar enum yang ditentukan tidak dapat disimpan. | HTTP Status 302 redirect back. Pesan error `The selected status is invalid.` muncul pada form. Data tidak masuk ke tabel MySQL. | **LULUS** | Validasi membatasi integritas nilai status kursus. |
| 8 | **Daftar Tampil Ulang (Persistence)** | Akses ulang / reload halaman `GET /courses` | Seluruh data yang telah tersimpan di MySQL tetap tampil lengkap di tabel dengan format yang rapi (biaya berformat Rupiah, tanggal berformat `d/m/Y`, dan badge status). | Halaman menampilkan seluruh baris data kursus yang tersimpan di MySQL secara konsisten. Data persisten dan tidak hilang saat halaman di-reload. | **LULUS** | Query `Course::latest()->get()` berhasil membaca data persisten dari MySQL `kursus_riri`. |

---

### Kesimpulan Pengujian:
- **Total Test Case:** 8 Skenario
- **Hasil Lulus:** 8 (100%)
- **Hasil Gagal:** 0 (0%)
- **Status Akhir Pengujian:** **LULUS**
