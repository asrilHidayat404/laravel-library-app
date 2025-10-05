# 📚 Aplikasi Manajemen Perpustakaan

Aplikasi ini dibangun menggunakan **Laravel 8** untuk membantu pengelolaan data perpustakaan secara digital.  
Fitur utama meliputi manajemen anggota, buku, peminjaman, API endpoint, pengiriman email dengan **queue**, serta ekspor data ke **Excel**.

---

## 🚀 Teknologi yang Digunakan

- ⚙️ **Laravel 8**
- 🧩 **Blade Template Engine**
- 💾 **MySQL 5.7+**
- 💡 **jQuery**
- 📨 **Queue & Mail (SMTP)**
- 📊 **Maatwebsite/Excel**

---

## ⚙️ Fitur Utama

### 🔐 Autentikasi
- Login & logout untuk admin/operator.

### 👥 Manajemen Anggota
- Tambah, ubah, hapus, dan tampilkan data anggota.

### 📘 Manajemen Buku
- Tambah, ubah, hapus, dan tampilkan data buku.

### 📖 Manajemen Peminjaman Buku
- Catat transaksi peminjaman dan pengembalian buku anggota.

### 🔄 API Endpoint

| Method | Endpoint | Deskripsi |
|---------|-----------|-----------|
| `GET` | `/api/books` | Menampilkan daftar buku (JSON) |
| `POST` | `/api/borrow` | Menambahkan data peminjaman baru |
| `GET` | `/api/borrow/{id}` | Menampilkan detail peminjaman berdasarkan ID |

### 📩 Queue + Email
- Setelah peminjaman dibuat, sistem otomatis mengirim email notifikasi ke anggota.
- Menggunakan **queue driver `database`** agar pengiriman email tidak memperlambat request utama.

### 📊 Export Excel
- Tombol **Export Excel** tersedia di halaman peminjaman.
- Data akan diekspor ke file `.xlsx` menggunakan package **Maatwebsite/Excel**.

---

## 🗃️ Struktur Database

Semua tabel dibuat menggunakan **migration** dan dapat diisi dengan **seeder**:

- 10 data anggota
- 20 data buku
- 30 data peminjaman

---

## 🧱 Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan perangkat kamu sudah memiliki:

- 🟢 **PHP** versi 7.4 atau lebih baru  
- 🟢 **Composer**  
- 🟢 **Node.js** versi 18 atau lebih baru  
- 🟢 **MySQL** versi 5.7 atau lebih baru  
- 🟢 **Laragon / XAMPP** (opsional untuk local server)

---

## 🧰 Langkah Instalasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/asrilHidayat404/laravel-library-app.git
cd laravel-library-app
```

### 2️⃣ Siapkan File Environment
```bash
cp .env.example .env
```

### 3️⃣ Install Dependency
```bash
composer install
npm install
npm run dev
```

### 4️⃣ Generate Application Key
```bash
php artisan key:generate
```

### 5️⃣ Buat Storage Link
```bash
php artisan storage:link
```

### 6️⃣ Buat Database di MySQL
Masuk ke MySQL:
```bash
mysql -u root -p
```

Lalu buat database:
```sql
CREATE DATABASE nama_database;
```

### 7️⃣ Sesuaikan Konfigurasi Database di `.env`
```env
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

### 8️⃣ Jalankan Migrasi
```bash
php artisan migrate 

php artisan db:seed
```

### 9️⃣ Konfigurasi Mail
Jika menggunakan notifikasi email:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME="emailkamu@gmail.com"
MAIL_PASSWORD="password_aplikasi"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="emailkamu@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

> ⚠️ Untuk Gmail, pastikan kamu sudah membuat **App Password** melalui [Google Account → Security → App Passwords](https://myaccount.google.com/apppasswords).

### 🔟 Jalankan Queue Worker (untuk email)
```bash
php artisan queue:work
```

### 1️⃣1️⃣ Jalankan Server Lokal
```bash
php artisan serve
```

Akses aplikasi di browser:
```
http://localhost:8000
```

---

## 👨‍💻 Akun Default (migrasi)
Jika tersedia di seeder:
- **Email:** admin@gmail.com 
- **Password:** password  

---

---

## 🧾 Lisensi
Proyek ini dibuat untuk tujuan pembelajaran dan pengembangan sistem perpustakaan berbasis Laravel.  
Lisensi mengikuti ketentuan **MIT License**.
