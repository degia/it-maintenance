# IT Maintenance Management System

Sistem manajemen pemeliharaan perangkat IT berbasis web dengan fitur CRUD master data, maintenance tracking, export/import data, dan role-based access control.

---

## Fitur

- **Manajemen Maintenance** — Preventive, Corrective, Predictive dengan jadwal task
- **Form Pemeriksaan Perangkat IT** — Pencatatan kondisi perangkat
- **Report Maintenance** — Laporan riwayat maintenance
- **Database Master Data** — 18 tabel referensi (level, direktorat, divisi, departemen, site, employee, asset, AD, email, dll.)
- **Database Settings** — CRUD generik untuk seluruh tabel master dengan form yang terintegrasi (FK dropdown)
- **Search & Filter** — Pencarian real-time di setiap tabel data
- **Export** — CSV, XLSX, XLS, HTML, PDF (filtered export, sinkron dengan search)
- **Import CSV** — Import data dari file CSV ke tabel master
- **Role-Based Access** — 4 level pengguna dengan sidebar yang berbeda
- **Login System** — Session-based authentication dengan bcrypt

---

## Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend | PHP 8.2 (Procedural, no framework) |
| Database | MySQL (MariaDB) via PDO |
| Frontend | Bootstrap 5.3, Custom CSS |
| Export | Native PHP (CSV, HTML, XLS), SimpleXLSX (XLSX), SimplePDF (PDF) |
| Seeding | Parsing `.xlsx` via ZipArchive + SimpleXML |

---

## Instalasi

### 1. Clone / Copy ke Server

Letakkan seluruh folder proyek ke `C:\xampp\htdocs\www\project\it-maintenance\` (atau direktori web server Anda).

### 2. Buat Database

```
mysql -u root -e "CREATE DATABASE IF NOT EXISTS it_maintenance CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
```

### 3. Import Schema

```
mysql -u root it_maintenance < database/schema_full.sql
```

Atau jalankan langsung dari phpMyAdmin.

### 4. Seed Data

```
php database/seed_full.php
```

Perintah ini membaca `data/structure_data.xlsx` dan mengisi seluruh 18 tabel dengan data awal.

### 5. Seed Users

```
php database/seed_users.php
```

Membuat akun demo (admin, teknisi, viewer, user) — lihat bagian **Demo Credentials**.

### 6. Akses Aplikasi

Buka browser: `http://localhost/project/it-maintenance/login.php`

---

## Demo Credentials

| Role | Username | Password |
|------|----------|----------|
| Administrator | `admin` | `admin123` |
| Technician | `teknisi` | `teknisi123` |
| Viewer | `viewer` | `viewer123` |
| User | `user` | `user123` |

---

## Role & Hak Akses

| Menu | Admin | Teknisi | Viewer | User |
|------|-------|---------|--------|------|
| Home (Dashboard) | ✔ | ✔ | ✔ | ✔ |
| Form Pemeriksaan | ✔ | ✔ | ✘ | ✔ |
| Maintenance (Preventive, Corrective, Predictive) | ✔ | ✔ | ✔ | ✔ |
| Report Maintenance | ✔ | ✔ | ✘ | ✔ |
| Database (User, Assets, Sites) | ✔ | ✔ | ✘ | ✘ |
| Database Settings (CRUD master data) | ✔ | ✔ | ✘ | ✘ |

---

## Struktur Proyek

```
it-maintenance/
├── css/
│   └── style.css              # Seluruh styling aplikasi
├── data/
│   ├── structure_data.xlsx    # Data seed untuk 18 tabel
│   └── DIAGRAM-PROJECT.pdf    # Entity Relationship Diagram
├── database/
│   ├── schema_full.sql        # Skema database lengkap (18 tabel)
│   ├── seed_full.php          # Seeder semua tabel dari .xlsx
│   └── seed_users.php         # Seeder akun demo
├── includes/
│   ├── auth.php               # Session helper & role check
│   ├── sidebar.php            # Navigasi sidebar
│   └── export_helper.php      # SimpleXLSX & SimplePDF classes
├── pages/
│   ├── home.php               # Dashboard utama
│   ├── form.php               # Form pemeriksaan perangkat
│   ├── report_maintenance.php # Laporan maintenance
│   ├── settings.php           # Dashboard settings (card menu)
│   ├── settings_table.php     # CRUD generik per tabel
│   ├── database/
│   │   ├── user.php           # View database user
│   │   ├── assets.php         # View database assets
│   │   └── sites.php          # View database sites
│   └── maintenance/
│       ├── preventive.php     # Maintenance preventive
│       ├── corrective.php     # Maintenance corrective
│       └── predictive.php     # Maintenance predictive
├── index.php                  # Entry point + routing
├── login.php                  # Halaman login
├── logout.php                 # Logout
├── db.php                     # Koneksi database PDO
├── process_settings.php       # Handler CRUD + import CSV
├── export_settings.php        # Handler export (5 format)
├── process.php                # Handler form pemeriksaan
├── process_maintenance.php    # Handler maintenance
└── README.md                  # Dokumentasi ini
```

---

## Database Schema (18 Tabel)

### Reference / Master Tables

| # | Tabel | Primary Key | Deskripsi |
|---|-------|-------------|-----------|
| 1 | `level` | `code` | Level jabatan |
| 2 | `directorate` | `code` | Direktorat |
| 3 | `division` | `code` | Divisi |
| 4 | `department` | `code` | Departemen |
| 5 | `sub_department` | `code` | Sub departemen (relasi ke dept/div/dir) |
| 6 | `business_unit` | `code` | Business unit |
| 7 | `corp` | `code` | Perusahaan |
| 8 | `item` | `code_item` | Kategori asset |
| 9 | `site` | `id_site` | Lokasi/site |
| 10 | `employee` | `nip` | Data karyawan |
| 11 | `email` | `email` | Akun email |
| 12 | `ad` | `username` | Active Directory (relasi ke employee via `pic_nip`) |

### Operational Tables

| # | Tabel | Primary Key | Deskripsi |
|---|-------|-------------|-----------|
| 13 | `workstation` | `id_asset` | Inventaris perangkat |
| 14 | `q_ws` | `id` (auto) | Definisi kolom workstation |
| 15 | `me` | `id_maintenance` | Tipe maintenance |
| 16 | `task` | `id_task` | Jadwal task maintenance |
| 17 | `wh` | `id_wh` | Status warehouse |
| 18 | `am` | `barcode` | Manajemen asset (PR/PO) |

### Foreign Key Relationships

```
employee
  ├── id_level         → level(code)
  ├── id_directorate   → directorate(code)
  ├── id_division      → division(code)
  ├── id_department    → department(code)
  ├── id_sub_department → sub_department(code)
  ├── business_unit    → business_unit(code)
  ├── site_unit        → site(id_site)
  └── corporate_name   → corp(code)

sub_department
  ├── department_id    → department(code)
  ├── division_id      → division(code)
  └── directorate_id   → directorate(code)

site
  ├── business_unit    → business_unit(code)
  └── company          → corp(code)

email.nip              → employee(nip)
ad.pic_nip             → employee(nip)
workstation.pic_nip    → employee(nip)
workstation.location   → site(id_site)
task.id_maintenance    → me(id_maintenance)
wh.id_asset            → workstation(id_asset)
wh.wh_site             → site(id_site)
am.code_item           → item(code_item)
am.id_site             → site(id_site)
```

---

## Fitur CRUD Settings

Setiap tabel master dapat dikelola melalui menu **Database Settings**:

1. **Tambah** — Modal form dengan field otomatis (text, select FK, enum, date, number, textarea)
2. **Edit** — Modal pre-populated dengan data existing; FK fields berupa dropdown
3. **Hapus** — Konfirmasi delete dengan prepared statement
4. **Search** — Filter data di semua kolom via server-side LIKE query
5. **Export** — Download data (termasuk hasil search) dalam 5 format
6. **Import CSV** — Upload CSV dengan header matching kolom tabel

### Export

| Format | File Extension | Implementasi |
|--------|---------------|--------------|
| CSV | `.csv` | Native PHP (BOM UTF-8 untuk Excel) |
| XLSX | `.xlsx` | SimpleXLSX (ZipArchive + XMLWriter) |
| XLS | `.xls` | HTML table dengan header MSO Excel |
| HTML | `.html` | HTML table standar |
| PDF | `.pdf` | SimplePDF (native PDF spec, library-free) |

---

## Pengembangan

### Menambahkan Tabel Baru

1. Tambahkan `CREATE TABLE` di `database/schema_full.sql`
2. Tambahkan sheet di `data/structure_data.xlsx` dan handler di `database/seed_full.php`
3. Tambahkan entry di `$table_labels`, `$pk_overrides`, dan `$allowed_tables` di:
   - `pages/settings_table.php`
   - `export_settings.php`
   - `process_settings.php` (jika perlu)
4. Tambahkan definisi FK di `$fk_cols` di `settings_table.php`

### Menambahkan Role Baru

1. Tambahkan level di array `$levels` pada fungsi `role_at_least()` di `includes/auth.php`
2. Edit sidebar visibility di `includes/sidebar.php`

---

## Troubleshooting

**"Koneksi database gagal"** — Pastikan MySQL running dan kredensial di `db.php` benar.

**"Failed to open xlsx" saat seed** — Pastikan `data/structure_data.xlsx` ada dan tidak sedang dibuka program lain.

**Data tidak muncul setelah import** — Gunakan `INSERT IGNORE` agar baris duplikat (PK sama) tidak gagal total.

**Error "Uncaught" saat edit** — Periksa apakah nilai data mengandung karakter `'` (single quote). Sistem sudah menangani ini dengan `ENT_QUOTES`.

---

## Lisensi

Hak cipta © 2026 — Penggunaan internal perusahaan.
