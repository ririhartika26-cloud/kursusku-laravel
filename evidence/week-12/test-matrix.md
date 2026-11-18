# Matrix Pengujian Praktikum Pertemuan 12: Relational Database

**Aplikasi**: KursusKu  
**Framework**: Laravel 13 (PHP 8.3, MySQL 8.4 via Laragon)  
**Database**: `kursus_riri`  
**Waktu Eksekusi**: 18 November 2026  
**Status Keseluruhan**: **11/11 PASSED (100% Lolos)**

---

## 1. Ringkasan Hasil Pengujian

| Kategori Pengujian | Total Kasus | Lolos | Gagal | Persentase |
| :--- | :---: | :---: | :---: | :---: |
| Antarmuka & Form Render | 1 | 1 | 0 | 100% |
| Validasi Input Form | 3 | 3 | 0 | 100% |
| Penyimpanan Relasional (Eloquent) | 3 | 3 | 0 | 100% |
| Integritas Komposit Unik | 1 | 1 | 0 | 100% |
| Laporan & Eager Loading | 1 | 1 | 0 | 100% |
| Integritas Referensial (ON DELETE CASCADE) | 2 | 2 | 0 | 100% |
| **TOTAL** | **11** | **11** | **0** | **100%** |

---

## 2. Rincian Matrix Kasus Uji

### TC-01: Form Render & Data Population
- **Modul**: `EnrollmentController@create`
- **Tujuan**: Memastikan halaman form pendaftaran berhasil menampilkan data peserta terdaftar dan program kursus terbuka.
- **Input**: HTTP GET `/enrollments/create`
- **Ekspektasi**: View `enrollments.create` dirender dengan data `$participants` (minimal 3 orang) dan `$courses` (hanya status `open`).
- **Hasil Aktual**: Form dirender sempurna, menampilkan 3 peserta terdaftar dan 5 kursus berstatus terbuka.
- **Status**: **PASSED**

---

### TC-02: Validasi Input Kosong (Empty Payload)
- **Modul**: `EnrollmentController@store`
- **Tujuan**: Mencegah penyimpanan ketika form disubmit tanpa memilih peserta dan kursus.
- **Input**: HTTP POST `/enrollments` dengan payload `[]`
- **Ekspektasi**: Melempar `ValidationException` dengan pesan error untuk field `participant_id` dan `course_id`.
- **Hasil Aktual**: Lolos validasi penolakan. Pesan error `participant_id` dan `course_id` terpicu dengan benar.
- **Status**: **PASSED**

---

### TC-03: Validasi Peserta Kosong
- **Modul**: `EnrollmentController@store`
- **Tujuan**: Memastikan field peserta wajib dipilih.
- **Input**: HTTP POST `/enrollments` dengan payload `['course_id' => 1]`
- **Ekspektasi**: Melempar error validasi: `"Peserta wajib dipilih."`
- **Hasil Aktual**: Error validasi mengembalikan pesan: `"Peserta wajib dipilih."`
- **Status**: **PASSED**

---

### TC-04: Validasi Kursus Kosong
- **Modul**: `EnrollmentController@store`
- **Tujuan**: Memastikan field kursus wajib dipilih.
- **Input**: HTTP POST `/enrollments` dengan payload `['participant_id' => 1]`
- **Ekspektasi**: Melempar error validasi: `"Kursus wajib dipilih."`
- **Hasil Aktual**: Error validasi mengembalikan pesan: `"Kursus wajib dipilih."`
- **Status**: **PASSED**

---

### TC-05: Pendaftaran Berhasil (Alya Rahma ke Web Dasar)
- **Modul**: `EnrollmentController@store`
- **Tujuan**: Memastikan data pendaftaran baru berhasil disimpan ke tabel `enrollments`.
- **Input**: HTTP POST `/enrollments` dengan `participant_id = 1` (Alya Rahma) dan `course_id = 1` (WEB-101)
- **Ekspektasi**: Baris baru tersimpan di tabel `enrollments` dengan kolom `status = 'registered'`, timestamps terisi, dan redirect ke `enrollments.index`.
- **Hasil Aktual**: Tersimpan di database dengan status `registered` (ID Enrollment: 5).
- **Status**: **PASSED**

---

### TC-06: Penolakan Pendaftaran Duplikat (Composite Unique Constraint)
- **Modul**: `EnrollmentController@store`
- **Tujuan**: Mencegah peserta mendaftar lebih dari satu kali pada kursus yang sama.
- **Input**: HTTP POST `/enrollments` dengan `participant_id = 1` dan `course_id = 1` (duplikat dari TC-05)
- **Ekspektasi**: Validasi gagal dan mengembalikan pesan kustom: `"Participant ini sudah terdaftar pada course tersebut."`
- **Hasil Aktual**: Ditolak oleh validation rule komposit unik dengan pesan: `"Participant ini sudah terdaftar pada course tersebut."`
- **Status**: **PASSED**

---

### TC-07: Pendaftaran Berhasil untuk Kursus Lain (Alya Rahma ke PHP Fundamental)
- **Modul**: `EnrollmentController@store`
- **Tujuan**: Memastikan peserta yang sama dapat mendaftar kursus lain yang berbeda (relasi many-to-many).
- **Input**: HTTP POST `/enrollments` dengan `participant_id = 1` dan `course_id = 2` (PHP-101)
- **Ekspektasi**: Data pendaftaran kedua untuk Alya berhasil tersimpan tanpa konflik unik.
- **Hasil Aktual**: Tersimpan di database dengan status `registered` (ID Enrollment: 6).
- **Status**: **PASSED**

---

### TC-08: Pendaftaran Peserta Berbeda pada Kursus yang Sama (Bima Putra ke Web Dasar)
- **Modul**: `EnrollmentController@store`
- **Tujuan**: Memastikan kursus yang sama dapat diikuti oleh lebih dari satu peserta berbeda.
- **Input**: HTTP POST `/enrollments` dengan `participant_id = 2` (Bima Putra) dan `course_id = 1` (WEB-101)
- **Ekspektasi**: Data pendaftaran berhasil tersimpan.
- **Hasil Aktual**: Tersimpan di database dengan status `registered` (ID Enrollment: 7).
- **Status**: **PASSED**

---

### TC-09: Laporan Data Enrollment & Eager Loading Inspection
- **Modul**: `EnrollmentController@index`
- **Tujuan**: Memastikan halaman laporan data pendaftaran memuat relasi peserta dan kursus secara efisien (mencegah N+1 query problem).
- **Input**: HTTP GET `/enrollments`
- **Ekspektasi**: Mengembalikan view `enrollments.index` dengan relasi `participant` dan `course` yang telah di-eager load (`with(['participant', 'course'])`).
- **Hasil Aktual**: Query eager load berhasil memuat 3 data pendaftaran aktif beserta data nama peserta, email, kode kursus, dan tanggal mulai tanpa query N+1 tambahan.
- **Status**: **PASSED**

---

### TC-10: Uji Integritas Referensial A — Penghapusan Kursus (Course Deletion)
- **Modul**: MySQL InnoDB Foreign Key Constraint (`courses.id` -> `enrollments.course_id`)
- **Tujuan**: Memverifikasi aturan `ON DELETE CASCADE` ketika entitas induk `courses` dihapus.
- **Skenario Uji**:
  1. Buat kursus dummy terisolasi: `code = 'CAS-A101'`.
  2. Buat peserta dummy terisolasi: `email = 'cascade.a@example.test'`.
  3. Daftarkan enrollment antara kedua entitas tersebut.
  4. Hapus data kursus dummy.
- **Ekspektasi**: Data enrollment otomatis terhapus dari tabel `enrollments`. Data peserta dummy **tetap utuh**.
- **Hasil Aktual**: Enrollment id 8 otomatis terhapus oleh foreign key constraint engine InnoDB saat kursus dihapus. Peserta dummy tetap ada di database, kemudian dibersihkan.
- **Status**: **PASSED**

---

### TC-11: Uji Integritas Referensial B — Penghapusan Peserta (Participant Deletion)
- **Modul**: MySQL InnoDB Foreign Key Constraint (`participants.id` -> `enrollments.participant_id`)
- **Tujuan**: Memverifikasi aturan `ON DELETE CASCADE` ketika entitas induk `participants` dihapus.
- **Skenario Uji**:
  1. Buat kursus dummy terisolasi: `code = 'CAS-B101'`.
  2. Buat peserta dummy terisolasi: `email = 'cascade.b@example.test'`.
  3. Daftarkan enrollment antara kedua entitas tersebut.
  4. Hapus data peserta dummy.
- **Ekspektasi**: Data enrollment otomatis terhapus dari tabel `enrollments`. Data kursus dummy **tetap utuh**.
- **Hasil Aktual**: Enrollment id 9 otomatis terhapus oleh foreign key constraint engine InnoDB saat peserta dihapus. Kursus dummy tetap utuh di database, kemudian dibersihkan.
- **Status**: **PASSED**
