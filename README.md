# SIM Klinik Pratama - Modul Admisi

Sistem Informasi Manajemen untuk Klinik Pratama dengan fokus pada modul pendaftaran pasien (Admisi). Dibangun menggunakan Laravel 11 dan Tailwind CSS dengan desain yang clean dan modern.

## 🚀 Fitur Utama

- **Manajemen Data Pasien**
  - Auto-generate Nomor Rekam Medis (RM-YYYYMMDD-XXXX)
  - Validasi NIK untuk cek duplikasi pasien
  - Data lengkap pasien dengan kontak darurat
  
- **Pendaftaran Pasien**
  - Auto-generate Nomor Registrasi (REG/RJ/YYYYMMDD/XXXX)
  - Auto-generate Nomor Antrian per Poli (A001, B001, dst)
  - Support Rawat Jalan, Rawat Inap, dan IGD
  - Integrasi dengan Poli dan Dokter

- **Manajemen Poli & Dokter**
  - Master data Poliklinik
  - Jadwal dokter per hari
  - Filter dokter berdasarkan poli

- **Dashboard Real-time**
  - Total pendaftaran hari ini
  - Statistik per status (Menunggu, Diperiksa, Selesai)
  - List registrasi dengan pencarian dan filter

## 📋 Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Blade Templates + Tailwind CSS
- **Database:** MySQL
- **Styling:** Clean minimal design

## ⚙️ Instalasi

### Requirements
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM (untuk Tailwind CSS)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/wildhanry/Admisi.git
cd Admisi
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admisi
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migrasi & Seeder**
```bash
php artisan migrate:fresh --seed
```

6. **Compile Assets**
```bash
npm run dev
```

7. **Jalankan Server**
```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## 📊 Database Schema

### Tabel: `patients`
- `no_rm` (auto-generated)
- `nik` (unique, 16 digit)
- `name`, `date_of_birth`, `gender`
- `address`, `phone`, `blood_type`
- `emergency_contact_name`, `emergency_contact_phone`

### Tabel: `polyclinics`
- `name`, `code`
- `description`, `is_active`

### Tabel: `doctors`
- `name`, `specialization`
- `license_number`
- `schedule` (JSON format)
- `polyclinic_id`

### Tabel: `registrations`
- `registration_number` (auto-generated)
- `queue_number` (auto-generated per poli)
- `registration_type` (RAWAT_JALAN/RAWAT_INAP/IGD)
- `payment_method` (UMUM/BPJS/ASURANSI)
- `status` (MENUNGGU/DIPERIKSA/SELESAI/BATAL)
- Relations: `patient_id`, `polyclinic_id`, `doctor_id`

## 🎯 Cara Penggunaan

1. **Pendaftaran Pasien Baru**
   - Klik "Pendaftaran Baru" di menu
   - Masukkan NIK dan klik "Cek NIK"
   - Sistem akan cek apakah pasien sudah terdaftar
   - Lengkapi data pasien dan data pendaftaran
   - Submit untuk generate nomor RM, registrasi, dan antrian otomatis

2. **Update Status Pendaftaran**
   - Klik detail pada list pendaftaran
   - Update status sesuai progress (Menunggu → Diperiksa → Selesai)

3. **Dashboard**
   - Lihat statistik pendaftaran hari ini
   - Filter berdasarkan poli, status, atau tanggal
   - Cari berdasarkan nama/nomor RM

## 🔒 Business Logic

- **Nomor RM:** `RM-20260108-0001` (unique per hari)
- **Nomor Registrasi:** `REG/RJ/20260108/0001` (sesuai tipe)
- **Nomor Antrian:** `A001`, `B001` (per poli per hari, reset setiap hari)
- **Soft Deletes:** Semua tabel menggunakan soft delete untuk audit trail

## 📝 Seeder Data

Aplikasi sudah include seeder dengan:
- 5 Poliklinik (Umum, Gigi, KIA, Mata, THT)
- 5 Dokter dengan jadwal praktek

## 🤝 Contributing

Pull requests are welcome. Untuk perubahan besar, silakan buka issue terlebih dahulu untuk diskusi.

## 📄 License

[MIT](https://choosealicense.com/licenses/mit/)

## 👨‍💻 Author

**Wildhan RY**
- GitHub: [@wildhanry](https://github.com/wildhanry)

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
