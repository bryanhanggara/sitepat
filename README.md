# E-Ticket SITEPAT

Sistem layanan tiket digital untuk **Dinas Pendidikan Kota Prabumulih**. Aplikasi ini memungkinkan masyarakat mengajukan pengaduan atau permohonan layanan, memantau status tiket secara real-time, dan menerima jadwal pertemuan melalui email atau WhatsApp.

## Fitur Utama

### Pengguna (User)
- Registrasi dan login akun
- Membuat tiket layanan dengan subjek, deskripsi, dan lampiran PDF (maks. 10 MB)
- Melihat daftar tiket berdasarkan status: **Pending**, **Scheduled**, **Completed**
- Melihat detail tiket dan informasi janji pertemuan

### Admin
- Panel admin untuk mengelola semua tiket
- Menjadwalkan janji pertemuan (waktu, lokasi, catatan)
- Mengirim notifikasi email otomatis ke pengguna
- Redirect ke WhatsApp dengan pesan terisi otomatis (jika pengguna memiliki nomor telepon)
- Menandai tiket sebagai selesai

## Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend | Laravel 12, PHP 8.2+ |
| Autentikasi | Laravel Breeze |
| Database | MySQL |
| Frontend | Bootstrap 5, Blade Templates |
| Asset bundler | Vite, Tailwind CSS |
| Testing | Pest PHP |

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL
- Ekstensi PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## Instalasi

### 1. Clone repository

```bash
git clone <url-repository> eticket
cd eticket
```

### 2. Install dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME="E-Ticket SITEPAT"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eticket
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi dan seed database

```bash
php artisan migrate
php artisan db:seed
```

### 5. Buat symbolic link storage

```bash
php artisan storage:link
```

### 6. Jalankan aplikasi

**Development (server + queue + logs + Vite sekaligus):**

```bash
composer dev
```

**Atau jalankan secara terpisah:**

```bash
php artisan serve
npm run dev
```

Aplikasi akan tersedia di `http://localhost:8000`.

## Akun Demo

Setelah menjalankan seeder, akun berikut tersedia:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@eticket.test | password |
| User | user@eticket.test | password |

## Alur Kerja Tiket

```
Pending → Scheduled → Completed
```

1. **Pending** — Pengguna membuat tiket baru
2. **Scheduled** — Admin menjadwalkan janji pertemuan; pengguna menerima notifikasi email (dan opsi WhatsApp)
3. **Completed** — Admin menandai tiket selesai setelah pertemuan

## Struktur Route

| Route | Deskripsi |
|-------|-----------|
| `/` | Dashboard |
| `/tickets` | Daftar tiket pengguna |
| `/tickets/create` | Form buat tiket |
| `/tickets/{id}` | Detail tiket |
| `/admin/tickets` | Panel admin — daftar tiket |
| `/admin/tickets/{id}` | Panel admin — detail & jadwalkan pertemuan |

## Konfigurasi Email

Untuk mengirim notifikasi janji pertemuan via email, sesuaikan pengaturan mail di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS="noreply@sitepat.go.id"
MAIL_FROM_NAME="${APP_NAME}"
```

## Deploy ke Production

Setelah deploy ke server, jalankan script perbaikan storage:

```bash
chmod +x fix-server-storage.sh
./fix-server-storage.sh
```

Script ini akan:
- Membuat symbolic link `public/storage`
- Mengatur permission dan ownership direktori storage
- Membersihkan dan meng-cache konfigurasi Laravel

Pastikan juga menjalankan:

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan migrate --force
```

## Testing

```bash
composer test
# atau
php artisan test
```

## Struktur Direktori Penting

```
app/
├── Http/Controllers/
│   ├── TicketController.php          # CRUD tiket (user)
│   └── Admin/
│       ├── TicketAdminController.php # Kelola tiket (admin)
│       └── AppointmentController.php # Jadwalkan pertemuan
├── Models/
│   ├── Ticket.php
│   ├── Appointment.php
│   └── User.php
└── Notifications/
    └── AppointmentScheduled.php      # Notifikasi email

resources/views/
├── dashboard.blade.php
├── tickets/                          # Halaman user
└── admin/tickets/                    # Halaman admin

database/
├── migrations/
└── seeders/DatabaseSeeder.php
```

## Lisensi

Proyek ini menggunakan framework [Laravel](https://laravel.com) yang dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

**SITEPAT** — Dinas Pendidikan Kota Prabumulih  
Versi 1.2
