# 🍳 Rasa Rekomendasi

Platform rekomendasi resep berbasis web yang memungkinkan pengguna menemukan, berbagi, dan berinteraksi dengan resep masakan dari berbagai chef profesional. Sistem ini menyediakan fitur rekomendasi cerdas, konsultasi dengan chef, dan membership VIP untuk konten eksklusif.

---

## 📋 1. Gambaran Umum Proyek

**Rasa Rekomendasi** adalah aplikasi web yang dirancang untuk:
- 🍽️ **Menjelajahi Resep** - Pengguna dapat mencari dan melihat berbagai resep dengan filter kategori, tingkat kesulitan, dan durasi memasak
- 👨‍🍳 **Manajemen Resep Chef** - Chef dapat membuat, mengedit, dan mengelola resep mereka sendiri
- ⭐ **Rating & Review** - Pengguna dapat memberikan rating (1-5 bintang) dan komentar pada resep
- 💬 **Konsultasi dengan Chef** - Pengguna bisa berkonsultasi langsung dengan chef profesional tentang masakan
- 💳 **Membership VIP** - Akses konten eksklusif seperti video tutorial dan resep premium
- 📅 **Jadwal Chef** - Chef dapat mengatur jadwal ketersediaan untuk konsultasi
- 💬 **Real-time Messaging** - Sistem pesan langsung antara pengguna dan chef
- 📱 **WhatsApp Notifications** - Notifikasi otomatis via WhatsApp menggunakan Fonnte API

**Stack Teknologi:**
- Backend: Laravel 11 (PHP 8.1+)
- Frontend: Blade Template + Tailwind CSS + Vite
- Database: MySQL 8.0+
- Queue: Laravel Queue untuk background jobs

---

## 🏗️ 2. Struktur Modul Laravel

Aplikasi mengikuti arsitektur MVC (Model-View-Controller) dengan struktur sebagai berikut:

```
app/
├── Console/
│   └── Commands/                    # Custom artisan commands
│       └── SendWhatsAppNotification.php
│
├── Http/
│   ├── Controllers/                 # Business logic handlers
│   │   ├── DashboardController.php
│   │   ├── RecipeController.php     # CRUD Resep
│   │   ├── CategoryController.php   # Manajemen Kategori
│   │   ├── CommentRatingController.php
│   │   ├── ConsultationController.php
│   │   ├── MessageController.php
│   │   ├── ChefScheduleController.php
│   │   ├── VipPackageController.php
│   │   ├── TransactionController.php
│   │   └── UserController.php
│   │
│   ├── Middleware/                  # Request interceptors
│   │   ├── Authenticate.php
│   │   ├── IsAdmin.php
│   │   ├── IsChef.php
│   │   ├── IsUser.php
│   │   └── VerifyCsrfToken.php
│   │
│   └── Requests/                    # Form validation
│       ├── StoreRecipeRequest.php
│       ├── StoreConsultationRequest.php
│       └── ... (Validation requests lainnya)
│
├── Jobs/                            # Background queue jobs
│   ├── SendWhatsAppNotification.php
│   └── ProcessPayment.php
│
├── Models/                          # Database models & relationships
│   ├── User.php                     # User (admin, chef, user)
│   ├── Recipe.php                   # Resep
│   ├── Category.php                 # Kategori resep
│   ├── CommentRating.php            # Review & rating
│   ├── Consultation.php             # Konsultasi dengan chef
│   ├── Message.php                  # Pesan antar pengguna
│   ├── ChefSchedule.php             # Jadwal chef
│   ├── VipPackage.php               # Paket membership VIP
│   ├── Transaction.php              # Transaksi pembayaran
│   ├── Preference.php               # Preferensi pengguna
│   ├── RecipeSave.php               # Resep yang disimpan
│   └── Tag.php                      # Tag untuk resep
│
├── Providers/                       # Service providers
│   ├── AppServiceProvider.php
│   └── EventServiceProvider.php
│
└── View/
    └── Components/                  # Reusable Blade components
        ├── RecipeCard.php
        ├── ChefCard.php
        ├── RatingStars.php
        └── ... (Component lainnya)

routes/
├── web.php                          # Web routes
├── auth.php                         # Authentication routes
└── console.php                      # Console routes

resources/
├── css/
│   └── app.css                      # Tailwind CSS
├── js/
│   └── app.js                       # Alpine.js, bundle JS
└── views/
    ├── layouts/
    │   ├── app.blade.php
    │   └── auth.blade.php
    ├── recipes/
    │   ├── index.blade.php
    │   ├── show.blade.php
    │   └── create.blade.php
    ├── consultations/
    ├── admin/
    └── ... (View files lainnya)

database/
├── migrations/                      # Schema definitions
│   ├── 2024_01_01_000001_create_users_table.php
│   ├── 2024_01_01_000002_create_categories_table.php
│   ├── 2024_01_01_000003_create_recipes_table.php
│   ├── 2024_01_01_000004_create_preferences_table.php
│   ├── 2024_01_01_000005_create_comments_ratings_table.php
│   ├── 2024_01_01_000006_create_vip_packages_table.php
│   ├── 2024_01_01_000007_create_transactions_table.php
│   ├── 2024_01_01_000008_create_chef_schedules_table.php
│   ├── 2024_01_01_000009_create_consultations_table.php
│   ├── 2024_01_01_000010_create_messages_table.php
│   └── 2024_01_01_000011_create_supporting_tables.php
│
└── seeders/                         # Dummy data
    ├── DatabaseSeeder.php
    ├── UserSeeder.php
    ├── CategorySeeder.php
    ├── RecipeSeeder.php
    ├── TagSeeder.php
    ├── VipPackageSeeder.php
    ├── PreferenceSeeder.php
    ├── ChefScheduleSeeder.php
    ├── CommentRatingSeeder.php
    └── TransactionSeeder.php
```

---

## 🗄️ 3. Struktur Database

### Tabel Utama:

#### **1. users** - Data Pengguna
```sql
Table: users
├── id (BIGINT PRIMARY KEY)
├── name (VARCHAR) - Nama lengkap
├── email (VARCHAR UNIQUE) - Email
├── password (VARCHAR) - Password terenkripsi
├── role (ENUM: admin, chef, user) - Tipe pengguna
├── avatar (VARCHAR) - Foto profil
├── phone (VARCHAR) - Nomor telepon
├── bio (TEXT) - Biodata
├── is_vip (BOOLEAN) - Status VIP
├── vip_expires_at (TIMESTAMP) - Tanggal VIP berakhir
├── specialization (VARCHAR) - Keahlian chef (jika role=chef)
├── rating_avg (DECIMAL 3,2) - Rating rata-rata chef
├── is_active (BOOLEAN) - Status aktif
├── created_at (TIMESTAMP)
├── updated_at (TIMESTAMP)
└── deleted_at (TIMESTAMP) - Soft delete
```

**Role Pengguna:**
- **admin** - Mengelola sistem, moderasi konten, manajemen user
- **chef** - Membuat & mengelola resep, menerima konsultasi
- **user** - Melihat resep, rating, konsultasi, membership VIP

---

#### **2. categories** - Kategori Resep
```sql
Table: categories
├── id (BIGINT PRIMARY KEY)
├── name (VARCHAR) - Nama kategori
├── slug (VARCHAR UNIQUE) - URL identifier
├── description (TEXT) - Deskripsi
├── icon (VARCHAR) - Icon category
└── created_at (TIMESTAMP)
```

**Contoh kategori:**
- Masakan Indonesia
- Masakan Internasional
- Makanan Sehat
- Dessert & Kue
- Minuman

---

#### **3. recipes** - Data Resep
```sql
Table: recipes
├── id (BIGINT PRIMARY KEY)
├── chef_id (BIGINT FK -> users) - Chef pembuat
├── category_id (BIGINT FK -> categories) - Kategori
├── title (VARCHAR) - Judul resep
├── slug (VARCHAR UNIQUE) - URL identifier
├── description (TEXT) - Deskripsi lengkap
├── ingredients (JSON) - Bahan-bahan
│   └── [{"name":"...", "amount":"...", "unit":"..."}]
├── cooking_steps (JSON) - Langkah memasak
│   └── [{"step":1, "instruction":"...", "image":"..."}]
├── prep_time (INT) - Waktu persiapan (menit)
├── cook_time (INT) - Waktu memasak (menit)
├── difficulty (ENUM: easy, medium, hard) - Tingkat kesulitan
├── calories (INT) - Kalori per sajian
├── servings (INT) - Jumlah porsi
├── image (VARCHAR) - Foto utama
├── video_url (VARCHAR) - URL video (VIP-only)
├── is_vip_content (BOOLEAN) - Konten eksklusif VIP
├── allergens (JSON) - Alergen ["gluten", "nuts", "dairy"]
├── status (ENUM: draft, published, archived) - Status
├── rating_avg (DECIMAL 3,2) - Rating rata-rata
├── rating_count (INT) - Jumlah rating
├── view_count (INT) - Jumlah views
├── created_at (TIMESTAMP)
├── updated_at (TIMESTAMP)
└── deleted_at (TIMESTAMP)
```

---

#### **4. comments_ratings** - Review & Rating
```sql
Table: comments_ratings
├── id (BIGINT PRIMARY KEY)
├── user_id (BIGINT FK -> users) - Pengguna pemberi review
├── recipe_id (BIGINT FK -> recipes) - Resep yang direview
├── comment (TEXT) - Komentar
├── rating (TINYINT 1-5) - Bintang rating
├── is_approved (BOOLEAN) - Status moderasi
├── approved_at (TIMESTAMP) - Waktu approval
├── created_at (TIMESTAMP)
├── updated_at (TIMESTAMP)
├── deleted_at (TIMESTAMP)
└── UNIQUE (user_id, recipe_id) - 1 review per user per resep
```

---

#### **5. vip_packages** - Paket Membership VIP
```sql
Table: vip_packages
├── id (BIGINT PRIMARY KEY)
├── name (VARCHAR) - Nama paket
├── slug (VARCHAR UNIQUE) - URL identifier
├── duration_days (INT) - Durasi (hari)
├── price (DECIMAL 12,2) - Harga
├── features (JSON) - Fitur yang disertakan
├── description (TEXT) - Deskripsi
├── is_active (BOOLEAN) - Status aktif
└── created_at (TIMESTAMP)
```

**Contoh paket VIP:**
- Trial 7 Hari - Free
- Premium Monthly - Rp 50.000/bulan
- Premium Yearly - Rp 500.000/tahun

---

#### **6. transactions** - Transaksi Pembayaran
```sql
Table: transactions
├── id (BIGINT PRIMARY KEY)
├── invoice_number (VARCHAR UNIQUE) - Nomor invoice (RR-2024-00001)
├── user_id (BIGINT FK -> users) - Pengguna pembeli
├── vip_package_id (BIGINT FK -> vip_packages) - Paket VIP
├── amount (DECIMAL 12,2) - Jumlah pembayaran
├── payment_status (ENUM) - pending, success, failed, expired, refunded
├── payment_method (VARCHAR) - transfer_bank, qris, ewallet
├── payment_channel (VARCHAR) - BCA, Mandiri, GoPay, etc
├── payment_gateway_log (JSON) - Response payment gateway
├── paid_at (TIMESTAMP) - Waktu pembayaran
├── expired_at (TIMESTAMP) - Waktu kadaluarsa
├── vip_starts_at (TIMESTAMP) - Waktu VIP mulai
├── vip_ends_at (TIMESTAMP) - Waktu VIP berakhir
├── notes (TEXT) - Catatan tambahan
├── created_at (TIMESTAMP)
├── updated_at (TIMESTAMP)
└── deleted_at (TIMESTAMP)
```

---

#### **7. consultations** - Konsultasi dengan Chef
```sql
Table: consultations
├── id (BIGINT PRIMARY KEY)
├── user_id (BIGINT FK -> users) - Pengguna yang berkonsultasi
├── chef_id (BIGINT FK -> users) - Chef yang dikonsultasi
├── topic (VARCHAR) - Topik konsultasi
├── description (TEXT) - Deskripsi pertanyaan
├── status (ENUM) - pending, accepted, in_progress, completed, cancelled
├── scheduled_at (TIMESTAMP) - Waktu jadwal konsultasi
├── completed_at (TIMESTAMP) - Waktu selesai
├── notes (TEXT) - Catatan hasil konsultasi
├── created_at (TIMESTAMP)
├── updated_at (TIMESTAMP)
└── deleted_at (TIMESTAMP)
```

---

#### **8. messages** - Pesan Antar Pengguna
```sql
Table: messages
├── id (BIGINT PRIMARY KEY)
├── sender_id (BIGINT FK -> users) - Pengirim pesan
├── receiver_id (BIGINT FK -> users) - Penerima pesan
├── consultation_id (BIGINT FK -> consultations) - Konsultasi terkait (opsional)
├── content (TEXT) - Isi pesan
├── attachment (VARCHAR) - File attachment URL
├── is_read (BOOLEAN) - Status pesan dibaca
├── read_at (TIMESTAMP) - Waktu dibaca
├── created_at (TIMESTAMP)
└── updated_at (TIMESTAMP)
```

---

#### **9. chef_schedules** - Jadwal Chef
```sql
Table: chef_schedules
├── id (BIGINT PRIMARY KEY)
├── chef_id (BIGINT FK -> users) - Chef
├── day_of_week (TINYINT) - Hari (0=Minggu, 6=Sabtu)
├── start_time (TIME) - Waktu mulai
├── end_time (TIME) - Waktu berakhir
├── is_available (BOOLEAN) - Status tersedia
└── created_at (TIMESTAMP)
```

---

#### **10. preferences** - Preferensi Pengguna
```sql
Table: preferences
├── id (BIGINT PRIMARY KEY)
├── user_id (BIGINT FK -> users) - Pengguna
├── category_id (BIGINT FK -> categories) - Kategori pilihan
├── preference_level (TINYINT 1-5) - Tingkat preferensi
└── created_at (TIMESTAMP)
```

---

#### **11. recipe_saves** - Resep yang Disimpan
```sql
Table: recipe_saves
├── id (BIGINT PRIMARY KEY)
├── user_id (BIGINT FK -> users) - Pengguna
├── recipe_id (BIGINT FK -> recipes) - Resep
├── created_at (TIMESTAMP)
└── UNIQUE (user_id, recipe_id) - 1 save per user per resep
```

---

#### **12. tags** - Tag untuk Resep
```sql
Table: tags
├── id (BIGINT PRIMARY KEY)
├── name (VARCHAR) - Nama tag
├── slug (VARCHAR UNIQUE) - URL identifier
└── created_at (TIMESTAMP)
```

**Contoh tag:**
- vegetarian
- gluten-free
- quick & easy
- healthy
- budget-friendly

---

## 👥 7. Tim Developer

| No | Nama | Role | Status | Deskripsi Tugas |
|----|------|------|--------|-----------------|
| 1 | Fazri Lukman Nurrohman | Project Manager | ✅ | Koordinasi tim, manajemen proyek dan timeline |
| 2 | Rizky Ramdan | Business Analyst | 🔄 IN PROGRESS | Analisis kebutuhan, spesifikasi fitur, user stories |
| 3 | Fahmi Nashruddin | UI/UX Designer | ✅ | Desain interface, wireframe, prototyping |
| 4 | Putra | UI/UX Designer | ✅ | Desain interface, UI consistency, testing desain |
| 5 | Ahmad Faiz Zaenuddin | QA (SQA) | 🔄 IN PROGRESS | Testing, bug reporting, quality assurance |
| 6 | Rifqi Fauzi Anwar | Lead Programmer | ✅ | Arsitektur sistem, auth, dashboard, queue notification |
| 7 | Azfa Salsabila | Business Analyst | 🔄 IN PROGRESS | Requirement analysis, dokumentasi, user research |
| 8 | Atik Wulandari | Scrum Master | 🔄 IN PROGRESS | Agile facilitation, sprint planning, retrospective |
| 9 | Ibnu | Programmer | ❌ BELUM | Pengerjaan belum dimulai / Status: In Progress |

---

## 🚀 4. Panduan Setup untuk Clone Project

Ikuti langkah-langkah berikut untuk clone dan menjalankan project Rasa Rekomendasi di komputer lokal.

### Prerequisites (Kebutuhan Awal)

Pastikan sudah install tools berikut:

- **PHP** (>= 8.1) → [Download](https://www.php.net/downloads)
- **Composer** → [Download](https://getcomposer.org/download/)
- **MySQL** (>= 8.0) → [Download](https://www.mysql.com/downloads/)
- **Git** → [Download](https://git-scm.com/)
- **Node.js & npm** (>= 16.x) → [Download](https://nodejs.org/)

### Step 1: Clone Repository

```bash
git clone https://github.com/Fauziian/RasaRekomendasi.git
cd RasaRekomendasi
```

### Step 2: Setup Environment File

```bash
# Copy environment file template
cp .env.example .env
```

Edit file `.env` dengan konfigurasi lokal Anda:

```env
APP_NAME="Rasa Rekomendasi"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rasa_rekomendasi
DB_USERNAME=root
DB_PASSWORD=YOUR_PASSWORD

# Mail Configuration (opsional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=

# WhatsApp Notification (Fonnte API)
FONNTE_TOKEN=YOUR_FONNTE_API_TOKEN

# Payment Gateway (opsional)
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
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
# Buat database baru (jika belum ada)
mysql -u root -p -e "CREATE DATABASE rasa_rekomendasi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Jalankan migration untuk membuat tabel
php artisan migrate

# (Optional) Jalankan seeder untuk dummy data
php artisan db:seed
```

### Default Test Credentials

Setelah menjalankan `php artisan db:seed`, berikut adalah akun default yang tersedia untuk testing:

#### **👨‍💼 Admin Account**
```
Email: admin@rasarekomendasi.id
Password: password
Nama: Admin RasaRekomendasi
```

#### **👨‍🍳 Chef Accounts**
```
1. Chef Rina Sari
   Email: chef.rina@rasarekomendasi.id
   Password: password
   Spesialisasi: Masakan Indonesia & Jawa

2. Chef Budi Santoso
   Email: chef.budi@rasarekomendasi.id
   Password: password
   Spesialisasi: Masakan Asia & Fusion

3. Chef Dewi Kusuma
   Email: chef.dewi@rasarekomendasi.id
   Password: password
   Spesialisasi: Dessert & Pastry
```

#### **👥 Regular User Accounts**
```
1. Siti Rahayu
   Email: siti@example.com
   Password: password
   Status: Regular User

2. Budi Prakoso
   Email: budi@example.com
   Password: password
   Status: VIP (30 hari)

3. Mega Wulandari
   Email: mega@example.com
   Password: password
   Status: VIP (365 hari)

4. Rizki Pratama
   Email: rizki@example.com
   Password: password
   Status: Regular User

5. Ayu Lestari
   Email: ayu@example.com
   Password: password
   Status: Regular User
```

| Tipe | Total | Password Default |
|------|-------|------------------|
| Admin | 1 | password |
| Chef | 3 | password |
| User | 5 | password |
| **TOTAL** | **9** | **password** |

> **⚠️ PENTING:** Ubah password semua akun di environment production! Jangan gunakan password default ini di production.

### Step 6: Install Frontend Dependencies

```bash
npm install
```

### Step 7: Build Frontend Assets (Vite)

```bash
# Development mode (dengan hot reload)
npm run dev

# Production mode
npm run build
```

### Step 8: Start Development Server

Buka terminal baru dan jalankan:

```bash
php artisan serve
```

Akses aplikasi di: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

### Step 9: Setup Queues (Opsional)

Untuk menjalankan background jobs (WhatsApp notifications):

```bash
# Terminal terpisah
php artisan queue:work
```

---

## 🎯 5. Fitur Utama

### Untuk **User** (Regular Member)
- ✅ Browsing resep dengan filter kategori, kesulitan, durasi
- ✅ Melihat detail resep lengkap dengan ingredients & steps
- ✅ Rating dan review resep
- ✅ Simpan resep favorit
- ✅ Konsultasi dengan chef
- ✅ Chat dengan chef
- ✅ Subscribe membership VIP
- ✅ Akses ke resep premium jika VIP

### Untuk **Chef**
- ✅ Membuat & mengedit resep sendiri
- ✅ Upload foto dan video resep
- ✅ Atur jadwal ketersediaan untuk konsultasi
- ✅ Terima konsultasi dari user
- ✅ Chat dengan user
- ✅ Lihat rating dan review resep mereka
- ✅ Monetisasi resep eksklusif VIP
- ✅ Statistik view & rating resep

### Untuk **Admin**
- ✅ Manajemen user (approve chef, suspend user)
- ✅ Manajemen kategori dan tag
- ✅ Moderasi review dan komentar
- ✅ Kelola paket VIP membership
- ✅ Lihat laporan transaksi pembayaran
- ✅ Monitor sistem & database

---

## 🛠️ 6. Troubleshooting

### Error: "Class 'Dotenv\Dotenv' not found"
```bash
composer install
php artisan key:generate
```

### Error: Database Connection Refused
```bash
# Pastikan MySQL running
# Windows: mysql -u root -p
# Linux: sudo systemctl start mysql

# Update .env dengan DB credentials yang benar
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Error: "npm: command not found"
- Install Node.js dari https://nodejs.org/

### Error: Vite manifest not found
```bash
npm run build
```

### Error: CORS atau API errors
- Cek file `config/cors.php`
- Update `APP_URL` di `.env`

### Error: WhatsApp notifikasi tidak terkirim
- Cek Fonnte API token di `.env`
- Pastikan queue running: `php artisan queue:work`

---

## 📞 8. Kontak & Support

Untuk pertanyaan atau issue:
- **WhatsApp**: Hubungi Fazri Lukman Nurrohman (PM)
- **GitHub Issues**: [Issues Page](https://github.com/Fauziian/RasaRekomendasi/issues)
- **Email**: Hubungi tim development

---

## 📄 License

Project ini adalah **proprietary**. Dilarang copy atau gunakan tanpa izin dari tim development.

---

**Last Updated:** June 2026  
**Project Status:** In Development  
**Framework:** Laravel 11 | PHP 8.1+ | MySQL 8.0+
