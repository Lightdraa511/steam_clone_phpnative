# 🎮 Steam Clone - Web Store & Library Platform

<div align="center">

![Steam Logo](./image/header_logo.png)

Aplikasi web simulasi **Steam Store & Library** berbasis **PHP Native** dan **MySQL/MariaDB**, dikemas lengkap dengan lingkungan **Docker & Docker Compose** untuk kemudahan instalasi satu kali klik.

[![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MariaDB](https://img.shields.io/badge/MariaDB-10.4-003545?style=for-the-badge&logo=mariadb&logoColor=white)](https://mariadb.org/)
[![Apache](https://img.shields.io/badge/Apache-2.4-D22128?style=for-the-badge&logo=apache&logoColor=white)](https://httpd.apache.org/)
[![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com/)
[![phpMyAdmin](https://img.shields.io/badge/phpMyAdmin-Included-6C78AF?style=for-the-badge&logo=phpmyadmin&logoColor=white)](https://www.phpmyadmin.net/)

</div>

---

## 📌 Tentang Project

Project ini merupakan platform web dinamis terinspirasi dari **Steam**, yang mengintegrasikan pengalaman berbelanja game digital, perpustakaan game (*game library*), profil akun pengguna, serta panel kontrol manajemen untuk Administrator.

### ✨ Fitur Unggulan

#### 🛒 1. Pengalaman Pengguna (Storefront & Library)
- **Katalog Game Berdasarkan Genre:** Eksplorasi game berdasarkan kategori seperti *Survival*, *FPS*, *Action*, dan *Sports*.
- **Pencarian Cepat (*Game Search*):** Mencari game favorit berdasarkan judul secara instan.
- **Rincian Game (*Game Detail*):** Menampilkan cover art, developer, publisher, tanggal rilis, deskripsi, dan tombol pembelian.
- **Simulasi Transaksi & Checkout:** Sistem pembelian game yang otomatis mencatat log transaksi dan memasukkan game ke Library pengguna.
- **Library Game Pribadi:** Daftar koleksi game yang telah dibeli oleh akun yang sedang aktif.
- **Profil & Akun Pengguna:** Kustomisasi profil, upload foto avatar ke server, serta penggantian kata sandi dengan verifikasi hash aman.
- **Navigasi Responsif & Indikator Aktif:** Menu navbar otomatis menyala biru sesuai halaman yang sedang dibuka.

#### 🛠️ 2. Panel Administrator (Admin Mode)
- **Katalog Manajemen Game (CRUD):** Tambah game baru lengkap dengan upload gambar cover ke `gambargame/`, ubah info harga, deskripsi, tanggal rilis, dan genre.
- **Manajemen User Role:** Mengatur hak akses pengguna antara role `user` dan `admin`.
- **Riwayat Transaksi Global:** Memantau seluruh transaksi pembelian game dari seluruh user secara terpusat.

---

## 💻 Tech Stack

| Komponen | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Backend** | PHP 8.1 (Native / Procedural) | Autentikasi session, password hashing (`password_hash` & `password_verify`), routing |
| **Database** | MariaDB 10.4 / MySQL | Tabel relasional (`game`, `user`, `library`, `transaction`) |
| **Database GUI** | phpMyAdmin | Visualisasi & query database langsung via browser |
| **Web Server** | Apache 2.4 | Web server dengan modul `mod_rewrite` & ekstensi `mysqli` |
| **Containerization**| Docker & Docker Compose | Multi-container setup otomatis (Web, DB, phpMyAdmin) |
| **Frontend** | HTML5, CSS3, JavaScript | Styling tema Steam UI (*Dark mode aesthetic*) |

---

## 🔐 Kredensial & Akun Testing

Database sudah terisi dengan data bawaan (*seed data*) dari `steam (4).sql` yang siap langsung diuji coba:

### 👤 Akun Aplikasi

| Role | Username | Password | Akses & Kemampuan |
| :--- | :--- | :--- | :--- |
| 👑 **Administrator** | `Manager` | `Manager` | Mengakses seluruh Store, Library, serta menu **ADMIN MODE** (Kelola Game, User, & Transaksi) |
| 🎮 **Regular User** | `xx` | `xx` | Mengakses Store, membeli game, melihat Library yang sudah berisi game koleksi, dan kelola profil |

> [!TIP]
> Anda juga dapat membuat akun baru melalui halaman **Create an Account** (`add_user.php`).

---

### 🗄️ Kredensial Database & phpMyAdmin

| Parameter | Konfigurasi Docker | Konfigurasi Manual (XAMPP) |
| :--- | :--- | :--- |
| **Database Host** | `db` (internal Docker) / `localhost:3307` (dari host) | `localhost:3306` |
| **Database Name** | `steam` | `steam` |
| **Username** | `root` | `root` |
| **Password** | `rootpassword` | *(kosong)* |
| **phpMyAdmin URL** | `http://localhost:8081` | `http://localhost/phpmyadmin` |

---

## 🚀 Cara Menjalankan

Anda dapat menjalankan project ini dengan **dua cara**: menggunakan **Docker (Sangat Direkomendasikan)** atau **Manual via XAMPP/LAMPP**.

### 🐳 Opsi 1: Menggunakan Docker (Rekomendasi Linux / Mac / Windows)

Metode ini tidak memerlukan instalasi PHP maupun MySQL di sistem utama Anda. Cukup pastikan **Docker** dan **Docker Compose** sudah terpasang.

1. **Pastikan Docker berjalan:**
   ```bash
   docker --version
   docker compose version
   ```

2. **Jalankan container:**
   Jalankan perintah ini di direktori project:
   ```bash
   docker compose up -d --build
   ```

3. **Buka di Browser:**
   - **Aplikasi Steam:** [http://localhost:8080](http://localhost:8080)
   - **phpMyAdmin:** [http://localhost:8081](http://localhost:8081) *(Login: User `root` | Password `rootpassword`)*

4. **Perintah Docker yang sering digunakan:**
   ```bash
   # Melihat status container
   docker compose ps

   # Melihat log container secara langsung
   docker compose logs -f

   # Menghentikan container
   docker compose down

   # Menyalakan kembali container
   docker compose up -d
   ```

---

### 🖥️ Opsi 2: Menjalankan Secara Manual (XAMPP / LAMPP)

1. **Pindahkan folder project:**
   Salin atau letakkan folder project ini ke dalam folder `htdocs` (misal `/opt/lampp/htdocs/steam` atau `C:\xampp\htdocs\steam`).
2. **Start Apache & MySQL** pada control panel XAMPP Anda.
3. **Impor Database:**
   - Buka browser ke `http://localhost/phpmyadmin`.
   - Buat database baru bernama `steam`.
   - Pilih tab **Import**, lalu unggah file `steam (4).sql` yang ada di direktori project.
4. **Buka Aplikasi:**
   Akses melalui browser di `http://localhost/steam/index.php`.

---

## 📂 Struktur Direktori Project

```text
├── .dockerignore            # File yang diabaikan saat build Docker image
├── Dockerfile               # Konfigurasi image PHP 8.1 Apache + MySQLi
├── docker-compose.yml       # Orkestrasi container Web, MariaDB, dan phpMyAdmin
├── connection.php           # Koneksi database (mendukung Environment Variable & Localhost)
├── steam (4).sql            # Dump skema database dan data awal
│
├── index.php                # Halaman utama Storefront Steam
├── game_detail.php          # Halaman informasi detail game
├── result.php               # Halaman hasil pencarian game
├── library.php              # Halaman daftar game yang dimiliki user
│
├── form_login.php           # Form antarmuka login
├── login.php                # Pemroses autentikasi login pengguna
├── logout.php               # Pengakhir session pengguna
├── add_user.php             # Form pendaftaran akun baru
├── create_user.php          # Pemroses registrasi akun pengguna
├── profile.php              # Tampilan profil akun
├── edit_profile.php         # Edit profil & upload avatar
├── change_password.php      # Ganti kata sandi akun
│
├── games.php                # [Admin] Daftar katalog game
├── add_game.php             # [Admin] Tambah game baru & upload cover
├── edit_game.php            # [Admin] Edit informasi game
├── users.php                # [Admin] Kelola role pengguna (Admin/User)
├── transaction.php          # [Admin] Rekap riwayat transaksi seluruh pengguna
├── transaction_form.php     # Form proses checkout/pembelian game
│
├── nav.php                  # Komponen navigasi Store & Library (Active state ready)
├── navadmin.php             # Komponen navigasi Admin (Active state ready)
├── footer.php               # Komponen footer Steam/Valve
│
├── gambargame/              # Direktori penyimpanan poster/cover game yang diunggah
├── gambaruser/              # Direktori penyimpanan avatar pengguna
├── image/                   # Aset grafis statis UI Steam (logo, background, icon)
└── style/                   # Kumpulan stylesheet CSS untuk setiap halaman
```

---

## 🛡️ Hak Akses File (Permissions)

Jika menjalankan di lingkungan Linux tanpa Docker dan mengalami kegagalan saat upload gambar game atau avatar:
```bash
chmod -R 777 gambargame gambaruser
```
*(Pada mode Docker, hak akses ini sudah ditangani secara otomatis)*.

---

## 🤝 Kontribusi & Lisensi

Dibuat untuk keperluan edukasi, pembelajaran web development native, dan demonstrasi arsitektur aplikasi web klasik berbasis PHP & relational database. 

Asset grafis Steam adalah hak cipta dari **Valve Corporation**.
