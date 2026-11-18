# KursusKu - Platform Edukasi & Pelatihan Terpadu

KursusKu adalah aplikasi web platform edukasi dan pelatihan terstruktur yang dikembangkan menggunakan framework Laravel 13 dengan implementasi arsitektur Model-View-Controller (MVC), Blade Layouting, integrasi Bootstrap 5 & jQuery via bundler Vite, form validation, komunikasi asynchronous Ajax, siklus hidup CRUD Lengkap (Create, Read, Show, Edit, Update, Delete), serta arsitektur basis data relasional Many-to-Many terintegrasi (`Course`, `Participant`, dan `Enrollment` pivot) dengan proteksi integritas referensial foreign key `ON DELETE CASCADE`.

---

## 1. Deskripsi Proyek

Proyek ini telah mengintegrasikan fungsionalitas manajemen data kursus dan pendaftaran relasional secara menyeluruh:
- **Master Layout & Reusable Component:** Penggunaan master layout Blade tunggal (`layouts/app.blade.php`) dan partial navigation bar (`partials/navbar.blade.php`) untuk menjaga konsistensi antarmuka.
- **Frontend Dependencies via Vite:** Framework CSS Bootstrap 5, Popper.js, dan jQuery dipasang secara modular melalui npm dan dibundle oleh Vite tanpa menggunakan CDN eksternal.
- **Database MySQL & Migration:** Struktur tabel `courses`, `participants`, dan tabel pivot `enrollments` terkelola pada basis data `kursus_riri` dengan tipe data presisi (InnoDB Engine).
- **Model Eloquent & Relasi Many-to-Many (Pertemuan 12):**
  - Model `Participant` memiliki relasi `hasMany(Enrollment::class)` dan `belongsToMany(Course::class, 'enrollments')`.
  - Model `Course` memiliki relasi `hasMany(Enrollment::class)` dan `belongsToMany(Participant::class, 'enrollments')`.
  - Model `Enrollment` merepresentasikan pivot dengan relasi `belongsTo` ke `Participant` dan `Course`, serta menyimpan atribut pivot `status` dan timestamps.
- **Integritas Referensial & Anti-Duplikasi:**
  - Foreign key constraint InnoDB dengan aturan `ON DELETE CASCADE` untuk kedua relasi induk.
  - Indeks komposit unik ganda `UNIQUE (participant_id, course_id)` pada tingkat database schema dan validasi aplikasi `Rule::unique` untuk mencegah duplikasi pendaftaran kursus.
- **Eager Loading Optimization:** Halaman laporan pendaftaran memanfaatkan `$enrollments = Enrollment::with(['participant', 'course'])->latest()->get();` guna mengeliminasi potensi N+1 query problem.
- **CRUD Lengkap Kursus (Pertemuan 10 & 11):**
  - **Index (Read):** Menampilkan katalog kursus dari database MySQL dengan format biaya Rupiah, tanggal terformat, dan badge status.
  - **Create & Store (Insert):** Formulir penambahan kursus baru yang tervalidasi via `StoreCourseRequest`.
  - **Show (Detail):** Halaman rincian program kursus menggunakan Route Model Binding.
  - **Edit & Update:** Formulir pengeditan kursus yang mempertahankan data eksisting, divalidasi via `UpdateCourseRequest`.
  - **Destroy (Delete):** Penghapusan kursus menggunakan form method spoofing `@method('DELETE')` dan konfirmasi dialog.
- **Asynchronous Availability (jQuery Ajax):** Pengecekan kuota kursus secara dinamis dari database MySQL tanpa reload halaman.
- **Desain Warm Brown & White:** Identitas visual konsisten dengan palet Dark Chocolate (`#49352B`), Primary Brown (`#795548`), Medium Brown (`#A07858`), Warm Beige (`#E9DFD3`), dan Off White (`#FAF8F5`).

---

## 2. Kebutuhan Sistem (System Requirements)

- **PHP:** Versi 8.3 atau lebih baru.
- **Composer:** Versi 2.x.
- **Node.js:** Versi 20.x atau 22.x LTS.
- **npm:** Versi 10.x atau lebih baru.
- **Basis Data:** MySQL 8.x (disediakan via Laragon).
- **Web Server:** Apache / Nginx (direkomendasikan menggunakan Laragon).
- **Web Browser:** Google Chrome, Mozilla Firefox, atau browser modern lainnya.

---

## 3. Teknologi yang Digunakan

- **Backend Framework:** Laravel Framework 13 (PHP 8.3)
- **Database Engine:** MySQL 8.4 (Host: `127.0.0.1:3306`, Database: `kursus_riri`, Engine: InnoDB)
- **ORM:** Eloquent ORM (Relational Many-to-Many & Eager Loading)
- **Request Validation:** Laravel Form Request (`StoreCourseRequest`, `UpdateCourseRequest`) & Rule Object
- **Frontend Bundler:** Vite 8
- **CSS Framework:** Bootstrap 5.3 (via npm)
- **Tooltips/Popovers:** @popperjs/core 2.11
- **JavaScript Library:** jQuery 4.1 (via npm)
- **Templating Engine:** Laravel Blade

---

## 4. Struktur Direktori Utama

```text
kursusku-laravel/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php         # Controller landing page
│   │   │   ├── CourseController.php       # Controller CRUD lengkap kursus (7 actions)
│   │   │   └── EnrollmentController.php   # Controller relasi pendaftaran (create, store, index)
│   │   └── Requests/
│   │       ├── StoreCourseRequest.php     # Validasi penambahan kursus baru
│   │       └── UpdateCourseRequest.php    # Validasi pembaruan kursus (ignore ID)
│   └── Models/
│       ├── Course.php                     # Model Course (relasi enrollments & participants)
│       ├── Participant.php                # Model Participant (relasi enrollments & courses)
│       └── Enrollment.php                 # Model Pivot Enrollment (belongsTo Course & Participant)
│
├── database/
│   ├── migrations/
│   │   ├── ..._create_courses_table.php       # Migrasi blueprint tabel courses
│   │   ├── ..._create_participants_table.php  # Migrasi blueprint tabel participants
│   │   └── ..._create_enrollments_table.php   # Migrasi blueprint tabel pivot enrollments (CASCADE)
│   └── seeders/
│       ├── CourseSeeder.php               # Seeder data 8 kursus utama
│       └── ParticipantSeeder.php          # Seeder 3 data peserta terdaftar (idempoten)
│
├── docs/                                  # Dokumentasi teknis & laporan praktikum
│   ├── erd-pertemuan-12.md                # Perancangan ERD relasional lengkap
│   ├── audit-pertemuan-12.md              # Laporan audit pra-pengerjaan & backup
│   ├── refleksi-pertemuan-12.md           # Lembar refleksi mahasiswa Pertemuan 12
│   ├── FINAL-REPORT-week-12.md            # Laporan akhir praktikum Pertemuan 12
│   └── ...
│
├── evidence/                              # Bukti pengujian & arsip sumber
│   ├── week-07/                           # Bukti Pertemuan 7
│   ├── week-09/                           # Bukti Pertemuan 9
│   ├── week-10/                           # Bukti Pertemuan 10
│   ├── week-11/                           # Bukti Pertemuan 11
│   └── week-12/                           # Bukti Pertemuan 12
│       ├── erd-final.png                  # Diagram visual ERD Warm Brown & White
│       ├── test-matrix.md                 # Matriks 11 skenario pengujian relasional
│       ├── ai-usage-log.md                # Catatan transparansi AI usage log
│       └── source-files/                  # Salinan kode sumber final Pertemuan 12
│
├── public/                                # Dokumen root web server
│   ├── build/                             # Aset terkompilasi Vite (manifest, css, js)
│   ├── css/style.css                      # Stylesheet tema awal
│   └── images/hero-kursus.jpg             # Ilustrasi hero section
│
├── resources/
│   ├── css/app.css                        # Impor Bootstrap & styling Warm Brown
│   ├── js/app.js                          # Inisialisasi Bootstrap, jQuery & Ajax
│   └── views/
│       ├── layouts/app.blade.php          # Master layout utama aplikasi
│       ├── partials/navbar.blade.php      # Komponen navigasi reusable
│       ├── courses/
│       │   ├── index.blade.php            # Tampilan tabel daftar kursus & aksi
│       │   ├── create.blade.php           # Tampilan formulir tambah kursus
│       │   ├── show.blade.php             # Tampilan detail kursus
│       │   └── edit.blade.php             # Tampilan formulir edit kursus
│       ├── enrollments/
│       │   ├── create.blade.php           # Form pendaftaran relasi peserta & kursus
│       │   └── index.blade.php            # Laporan data enrollment relasional (eager load)
│       └── home.blade.php                 # Landing page
│
├── routes/web.php                         # Definisi rute aplikasi
├── .env.example                           # Contoh konfigurasi environment
├── composer.json                          # Dependensi PHP
└── package.json                           # Dependensi frontend npm
```

---

## 5. Konfigurasi Lingkungan (.env)

Aplikasi terhubung ke basis data `kursus_riri` pada server MySQL lokal. Konfigurasi pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kursus_riri
DB_USERNAME=root
DB_PASSWORD=
```

*Catatan: Sesuaikan nilai `DB_USERNAME` dan `DB_PASSWORD` dengan kredensial lingkungan MySQL Anda tanpa membagikan kata sandi ke dokumentasi publik.*

Setelah melakukan perubahan pada `.env`, bersihkan cache konfigurasi:

```bash
php artisan config:clear
```

---

## 6. Cara Instalasi & Menjalankan Proyek

1. **Masuk ke folder proyek:**
   ```bash
   cd D:\laragon\www\kursusku-laravel
   ```

2. **Pasang dependensi PHP dan frontend:**
   ```bash
   composer install
   npm install
   ```

3. **Kompilasi aset antarmuka (Production Build):**
   ```bash
   npm run build
   ```

4. **Jalankan migrasi basis data:**
   ```bash
   php artisan migrate
   ```

5. **Isi data awal peserta dan kursus (Seeder Idempoten):**
   ```bash
   php artisan db:seed --class=ParticipantSeeder
   ```

6. **Akses aplikasi melalui peramban web:**
   - Halaman Beranda: `http://kursusku-laravel.test/`
   - Daftar Kursus: `http://kursusku-laravel.test/courses`
   - Formulir Tambah Kursus: `http://kursusku-laravel.test/courses/create`
   - Laporan Data Enrollment: `http://kursusku-laravel.test/enrollments`
   - Formulir Pendaftaran Peserta: `http://kursusku-laravel.test/enrollments/create`
   - URL Kompatibilitas Pendaftaran: `http://kursusku-laravel.test/pendaftaran`

---

## 7. Arsitektur Basis Data Relasional (Pertemuan 12)

### A. Entity Relationship Diagram (ERD)

```
+--------------------+        +-------------------------+        +--------------------+
|    participants    |        |       enrollments       |        |      courses       |
+--------------------+        +-------------------------+        +--------------------+
| PK id              |<-------| FK participant_id       |        | PK id              |
|    name            | 1    N | FK course_id            |------->|    code            |
|    email (UNIQUE)  |        |    status               | N    1 |    name            |
|    phone           |        |    created_at           |        |    description     |
|    created_at      |        |    updated_at           |        |    fee             |
|    updated_at      |        | UNIQUE(part_id, crs_id) |        |    quota           |
+--------------------+        +-------------------------+        |    start_date      |
                                                                 |    status          |
                                                                 |    created_at      |
                                                                 |    updated_at      |
                                                                 +--------------------+
```

### B. Mekanisme Foreign Key & Cascade Delete
- Tabel `enrollments` menghubungkan `participants.id` dan `courses.id`.
- Diterapkan aturan `ON DELETE CASCADE` pada kedua foreign key constraint:
  - Jika suatu kursus dihapus, seluruh riwayat enrollment yang terhubung ke kursus tersebut otomatis terhapus tanpa menyisakan *orphaned record*, dan peserta terkait tetap aman.
  - Jika seorang peserta dihapus, seluruh riwayat enrollment peserta tersebut otomatis terhapus, dan program kursus terkait tetap aman.

### C. Proteksi Anti-Duplikasi (Composite Unique)
- Mencegah peserta yang sama mendaftar ke kursus yang sama lebih dari satu kali.
- Diterapkan secara berlapis:
  1. **Level Database Schema:** `$table->unique(['participant_id', 'course_id']);`
  2. **Level Validasi Controller:** `Rule::unique('enrollments')->where(fn($q) => $q->where('participant_id', $request->participant_id))`
  3. **Pesan Kustom:** *"Participant ini sudah terdaftar pada course tersebut."*

### D. Optimasi Query (Eager Loading)
- Pada laporan `EnrollmentController@index()`, relasi dimuat menggunakan eager loading:
  ```php
  Enrollment::with(['participant', 'course'])->latest()->get();
  ```
- Mencegah masalah query N+1, sehingga render tabel ribuan data tetap cepat dan efisien.

---

## 8. Batasan Ruang Lingkup

Fitur-fitur yang sengaja berada di luar cakupan praktikum pertemuan ini:
- Sistem Autentikasi Pengguna (Login/Register/Role Permissions).
- Fitur pencarian (*search*) dan penomoran halaman (*pagination*).
- Gateway pembayaran online (pendaftaran masih menggunakan status default `registered`).
