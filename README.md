# 🍳 RasaRekomendasi

Sistem berbasis web untuk mencacat, memverifikasi, dan melaporkan data kecacatan kain secara efisien, dengan notifikasi WhatsApp otomatis untuk mempercepat koordinasi antar tim.

## 🎯 1. Gambaran Umum Proyek

**Tujuan:** Sistem berbasis web untuk mencatat, memverifikasi, dan melaporkan data kecacatan kain secara efisien, dengan notifikasi WhatsApp otomatis untuk mempercepat koordinasi antar tim.

**Peran utama:**
- **User:** Petugas QC, Operator Produksi, dan Manager Produksi, Super Admin
- **DataCacat:** Catatan utama data cacat
- **Verifikasi:** Validasi data oleh QC/atasan
- **Laporan:** Rekapitulasi dan analisis otomatis
- **DashboardQC:** Statistik visual
- **Notification Queue (WhatsApp):** Otomasi pengiriman pesan berbasis antrian

---

## 📦 2. Struktur Modul Laravel

| Modul | Deskripsi | Route Prefix | Penanggung Jawab | Status |
|-------|-----------|--------------|-----------------|--------|
| **Auth** | Login, logout, dan setup awal super admin | `/auth` | Febriansah Dirgantara | ✅ Done |
| **User** | Manajemen pengguna, peran, dan WhatsApp ID | `/users` | Rizal Maulana | ✅ Done |
| **DataCacat** | CRUD data kecacatan kain | `/data-cacat` | Rifqi Fauzi Anwar | ✅ Done |
| **Verifikasi** | Proses validasi & konfirmasi data cacat | `/verifikasi` | Fazri Lukman | ✅ Done |
| **Laporan** | Rekap data, perhitungan, dan export PDF/Excel | `/laporan` | Rizal Maulana | ✅ Done |
| **Dashboard** | Visualisasi statistik data cacat dan kinerja mesin | `/dashboard` | Febriansah Dirgantara | ✅ Done |
| **Notification Queue** | Antrian pengiriman pesan WhatsApp otomatis (via Fonnte API atau sejenis) | `/notifications` | Febriansah Dirgantara | ✅ Done |

---

## 📁 3. Database Struktur

### Tabel 1: `users`
```php
Schema::create('users', function (Blueprint $table) {
    $table->id('id_user');
    $table->string('nama');
    $table->string('username')->unique();
    $table->string('email')->unique();
    $table->string('whatsapp')->unique()->nullable();
    $table->string('password');
    $table->string('role'); // admin, qc, verifikator
    $table->timestamps();
});
```

### Tabel 2: `jenis_cacat`
```php
Schema::create('jenis_cacat', function (Blueprint $table) {
    $table->id('id_jenis');
    $table->string('nama_jenis');
});
```

### Tabel 3: `data_cacat`
```php
Schema::create('data_cacat', function (Blueprint $table) {
    $table->id('id_cacat');
    $table->date('tanggal');
    $table->foreignId('id_jenis')->constrained('jenis_cacat');
    $table->integer('jumlah');
    $table->text('deskripsi')->nullable();
    $table->string('status'); // pending, verified, rejected
    $table->foreignId('id_user')->constrained('users');
    $table->timestamps();
});
```

*(Struktur database lengkap lihat di `/database/migrations`)*

---

## 🚀 4. Panduan Setup untuk Clone Project

Ikuti langkah-langkah berikut jika ingin clone dan menjalankan project ini di komputer Anda.

### Prerequisites (Kebutuhan Awal)

Pastikan Anda sudah install:
- **PHP** (>= 8.1) → [Download PHP](https://www.php.net/downloads)
- **Composer** → [Download Composer](https://getcomposer.org/download/)
- **MySQL** (atau Database lain) → [Download MySQL](https://www.mysql.com/downloads/)
- **Git** → [Download Git](https://git-scm.com/)
- **Node.js & npm** → [Download Node.js](https://nodejs.org/)

### Step 1: Clone Repository

```bash
git clone https://github.com/Fauziian/RasaRekomendasi.git
cd RasaRekomendasi
```

### Step 2: Setup Environment File

```bash
# Copy file contoh environment ke .env
cp .env.example .env
```

Kemudian edit `.env` dan sesuaikan dengan konfigurasi lokal Anda:

```env
APP_NAME="RasaRekomendasi"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rasa_rekomendasi
DB_USERNAME=root
DB_PASSWORD=YOUR_PASSWORD_HERE

# WhatsApp Notification (Fonnte API)
FONNTE_TOKEN=YOUR_FONNTE_TOKEN_HERE

# Generate APP_KEY
```

### Step 3: Install PHP Dependencies

```bash
composer install
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Setup Database

```bash
# Buat database baru
mysql -u root -p -e "CREATE DATABASE rasa_rekomendasi;"

# Jalankan migration
php artisan migrate

# (Optional) Jalankan seeder untuk dummy data
php artisan db:seed
```

### Step 6: Install Frontend Dependencies

```bash
npm install
```

### Step 7: Compile Assets (Vite)

```bash
# Development mode
npm run dev

# Production mode
npm run build
```

### Step 8: Start Development Server

Buka terminal baru dan jalankan:

```bash
php artisan serve
```

Server akan berjalan di: **http://127.0.0.1:8000**

---

## 🔐 5. Akun Default (Setelah Seeder)

| Role | Username | Password | Keterangan |
|------|----------|----------|-----------|
| **Super Admin** | admin | password | Setup awal system |
| **QC** | qc_user | password | Input & verifikasi data |
| **Manager** | manager_user | password | Lihat laporan |

> **⚠️ PENTING:** Ubah password default segera setelah login pertama kali!

---

## 📝 6. Struktur Folder Project

```
RasaRekomendasi/
├── app/
│   ├── Models/              # Model database
│   ├── Http/
│   │   ├── Controllers/     # Business logic
│   │   ├── Middleware/      # Middleware
│   │   └── Requests/        # Form validation
│   └── Jobs/                # Queue jobs
├── routes/
│   ├── web.php              # Web routes
│   └── auth.php             # Auth routes
├── database/
│   ├── migrations/          # Schema database
│   └── seeders/             # Dummy data
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Styling
│   └── js/                  # JavaScript
├── public/                  # Asset publik
├── storage/                 # File penyimpanan
├── vendor/                  # Dependencies (auto-generated)
└── .env                     # Environment config (jangan push!)
```

---

## 🛠️ 7. Troubleshooting

### Error: `Base table or view not found`
```bash
php artisan migrate --fresh
```

### Error: `SQLSTATE[HY000] [2002]`
Pastikan MySQL service sudah berjalan dan konfigurasi DB di `.env` benar.

### Error: `npm: command not found`
Pastikan Node.js sudah terinstall: `node -v`

### Port 8000 sudah terpakai?
```bash
php artisan serve --port=8080
```

---

## 👥 7. Tim Developer

- **Febriansah Dirgantara** - Auth, Dashboard, Notification Queue
- **Rizal Maulana** - User Management, Laporan
- **Rifqi Fauzi Anwar** - DataCacat CRUD
- **Fazri Lukman** - Verifikasi

---

## 📞 8. Kontak & Support

Jika ada pertanyaan atau issue, hubungi tim developer melalui WhatsApp atau GitHub Issues.

---

## 📄 License

Project ini adalah proprietary. Jangan copy atau gunakan tanpa izin.

---

**Last Updated:** June 2026
