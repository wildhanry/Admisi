# 📋 MODUL ADMISI - SIMRS Klinik Pratama

Modul Admisi untuk Sistem Informasi Manajemen Rumah Sakit (SIMRS) Klinik Pratama yang dibangun dengan Laravel 11 dan Tailwind CSS.

## 🚀 Fitur Utama

### ✅ Yang Sudah Diimplementasikan

1. **Database Schema**
   - ✓ Tabel `patients` - Data pasien dengan No RM unik
   - ✓ Tabel `doctors` - Master data dokter dengan jadwal
   - ✓ Tabel `polyclinics` - Data referensi poli/klinik
   - ✓ Tabel `registrations` - Transaksi pendaftaran (Rawat Jalan/Inap/IGD)

2. **Business Logic**
   - ✓ Auto-generate Nomor Rekam Medis (RM-YYYYMMDD-XXXX)
   - ✓ Auto-generate Nomor Registrasi (REG/TYPE/YYYYMMDD/XXXX)
   - ✓ Auto-generate Nomor Antrian per Poli per Hari
   - ✓ Validasi duplikasi NIK/No RM
   - ✓ Cek pasien existing saat input NIK

3. **User Interface**
   - ✓ Dashboard monitoring pendaftaran real-time
   - ✓ Form pendaftaran pasien baru yang responsif
   - ✓ Detail registrasi lengkap
   - ✓ Update status pendaftaran
   - ✓ Filter dokter berdasarkan poli
   - ✓ Modern UI dengan Tailwind CSS

## 📦 Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL
- **PHP Version**: 8.2+

## 🛠️ Setup & Installation

### 1. Clone & Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database di file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simrs_admisi
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Database Migration & Seeding

```bash
# Jalankan migrations
php artisan migrate

# Seed data master (poli & dokter)
php artisan db:seed

# Atau jalankan sekaligus
php artisan migrate:fresh --seed
```

**Default Login:**
- Email: `admin@simrs.com`
- Password: `password`

### 4. Build Assets & Run Server

```bash
# Build Tailwind CSS
npm run dev

# Atau untuk production
npm run build

# Jalankan Laravel server
php artisan serve
```

Akses aplikasi di: `http://localhost:8000/admissions`

## 📊 Struktur Database

### Tabel `patients`
```sql
- id (PK)
- no_rm (UNIQUE) - Auto-generated: RM-YYYYMMDD-XXXX
- nik (UNIQUE, 16 digit)
- name
- date_of_birth
- gender (L/P)
- address
- phone
- blood_type
- emergency_contact_name
- emergency_contact_phone
- timestamps
- soft_deletes
```

### Tabel `polyclinics`
```sql
- id (PK)
- code (UNIQUE)
- name
- description
- is_active
- timestamps
- soft_deletes
```

### Tabel `doctors`
```sql
- id (PK)
- code (UNIQUE)
- name
- specialization
- license_number (SIP/STR)
- phone, email
- polyclinic_id (FK)
- schedule (JSON)
- is_active
- timestamps
- soft_deletes
```

### Tabel `registrations`
```sql
- id (PK)
- registration_number (UNIQUE) - Auto: REG/RJ/YYYYMMDD/XXXX
- queue_number - Auto per poli per day
- patient_id (FK)
- doctor_id (FK)
- polyclinic_id (FK)
- registration_type (RAWAT_JALAN/RAWAT_INAP/IGD)
- payment_method (UMUM/BPJS/ASURANSI)
- insurance_number
- registration_date
- registration_time
- status (MENUNGGU/DIPERIKSA/SELESAI/BATAL)
- complaint
- notes
- registered_by (FK to users)
- timestamps
- soft_deletes
```

## 🔄 Business Flow - Proses Admisi

### 1. Input NIK Pasien
```
User memasukkan NIK → Klik "Cek NIK" → System check database
```

**Skenario A - Pasien Baru:**
- NIK tidak ditemukan
- Form data pasien aktif untuk diisi
- System akan generate No RM baru saat save

**Skenario B - Pasien Lama:**
- NIK ditemukan, tampilkan No RM
- Form data pasien auto-fill dari database
- Field data pasien menjadi read-only

### 2. Pilih Poli & Dokter
```
Pilih Poli → List dokter filtered berdasarkan poli yang dipilih
```

### 3. Pilih Metode Pembayaran
```
UMUM → Tidak perlu nomor kartu
BPJS/ASURANSI → Wajib input nomor kartu
```

### 4. Submit Pendaftaran
```
Validasi input → Transaction begin
→ Create/Update Patient
→ Generate Registration Number
→ Generate Queue Number
→ Save Registration
→ Transaction commit
→ Redirect ke halaman detail
```

### 5. Monitoring Dashboard
```
- Lihat semua pendaftaran hari ini
- Statistics: Total, Menunggu, Diperiksa, Selesai
- Update status pendaftaran
```

## 📝 Routing Structure

```php
GET  /admissions              → Dashboard (index)
GET  /admissions/create       → Form pendaftaran baru
POST /admissions              → Submit pendaftaran (store)
GET  /admissions/{id}         → Detail registrasi (show)
PATCH /admissions/{id}/status → Update status

// AJAX Endpoints
GET  /admissions/api/doctors/{polyclinic_id}
POST /admissions/api/check-patient
```

## 🎨 UI Components

### Pages
1. **Dashboard** (`admissions.index`) - Monitoring & statistik
2. **Form Pendaftaran** (`admissions.create`) - Input data baru
3. **Detail Registrasi** (`admissions.show`) - Info lengkap + update status

### Features
- ✅ Real-time doctor filtering by polyclinic
- ✅ NIK checker dengan AJAX
- ✅ Auto-fill form untuk pasien lama
- ✅ Conditional fields (nomor asuransi)
- ✅ Responsive design untuk mobile
- ✅ Color-coded status badges
- ✅ Clean & modern interface

## 🔐 Security Features

- CSRF Protection pada semua form
- Input validation (server-side)
- Soft deletes untuk audit trail
- Foreign key constraints
- Unique constraints (NIK, No RM, No Registrasi)
- SQL injection protection (Eloquent ORM)

## 📌 Best Practices yang Diterapkan

1. **Database Design**
   - Normalisasi database yang baik
   - Indexes pada kolom yang sering di-query
   - Soft deletes untuk data penting
   - JSON untuk data dinamis (jadwal dokter)

2. **Code Organization**
   - Separation of concerns (Model, View, Controller)
   - Eloquent relationships untuk query optimization
   - Scopes untuk reusable queries
   - Helper methods di Model

3. **Performance**
   - Eager loading untuk prevent N+1 queries
   - Database indexing
   - Pagination untuk large datasets

4. **User Experience**
   - Loading states
   - Error messages yang jelas
   - Success notifications
   - Responsive design

## 🚀 Development Tips

### Menambah Poli Baru
```php
// Di PolyclinicSeeder atau manual via tinker
Polyclinic::create([
    'code' => 'ORTHO',
    'name' => 'Poli Ortopedi',
    'description' => 'Pelayanan kesehatan tulang dan sendi',
    'is_active' => true,
]);
```

### Menambah Dokter Baru
```php
Doctor::create([
    'code' => 'DR006',
    'name' => 'dr. Example',
    'specialization' => 'Spesialis ...',
    'license_number' => 'SIP-006-2024',
    'polyclinic_id' => 1,
    'schedule' => [
        'Senin' => ['available' => true, 'start' => '08:00', 'end' => '12:00'],
    ],
    'is_active' => true,
]);
```

### Testing Manual
```bash
# Akses tinker
php artisan tinker

# Test generate No RM
Patient::generateNoRM();

# Test generate No Registrasi
Registration::generateRegistrationNumber('RAWAT_JALAN');

# Test generate Nomor Antrian
Registration::generateQueueNumber(1, date('Y-m-d'));
```

## 📊 Contoh Data Seeder

Data master yang sudah di-seed:
- **5 Poli**: Umum, Gigi, KIA, Mata, THT
- **5 Dokter** dengan jadwal praktik
- **1 Admin User** (admin@simrs.com / password)

## 🔜 Pengembangan Selanjutnya

Fitur yang bisa dikembangkan:
- [ ] Integrasi dengan bridging BPJS
- [ ] Cetak kartu berobat/bukti pendaftaran (PDF)
- [ ] SMS/WhatsApp notification untuk nomor antrian
- [ ] Queue display system (TV Monitor)
- [ ] Reporting & Analytics
- [ ] Online appointment booking
- [ ] Integration dengan EMR (Electronic Medical Record)

## 📞 Support

Jika ada pertanyaan atau issue, silakan hubungi tim development.

---

**Built with ❤️ using Laravel 11 & Tailwind CSS**
