
<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# KasirOrb

**KasirOrb** adalah aplikasi kasir berbasis web yang dikembangkan menggunakan **Laravel** dan **Tailwind CSS**. Aplikasi ini dirancang untuk memenuhi kebutuhan bisnis kecil hingga menengah dalam mengelola transaksi harian, stok produk, dan analisis penjualan dengan antarmuka yang intuitif, responsif, dan mudah digunakan.

## ✨ Fitur Utama

✅ **Autentikasi Pengguna**  
   - Sistem login dan registrasi dengan verifikasi email.  
   - Lupa kata sandi dengan reset melalui tautan aman.  

✅ **Dashboard Interaktif**  
   - Ringkasan transaksi harian, mingguan, dan bulanan.  
   - Grafik visual untuk tren penjualan dan performa produk terlaris.  
   - Notifikasi real-time untuk stok rendah atau transaksi tertunda.  

✅ **Manajemen Produk**  
   - Tambah, edit, dan hapus produk dengan detail seperti nama, harga, stok, dan kode barcode.  
   - Impor produk massal melalui file CSV atau Excel.  
   - Dukungan gambar produk untuk identifikasi visual.  

✅ **Manajemen Kategori & Varian**  
   - Pengelompokan produk berdasarkan kategori (misalnya: makanan, minuman, elektronik).  
   - Dukungan varian produk (ukuran, warna, dll.) dengan harga berbeda.  

✅ **Sistem Transaksi**  
   - Pencatatan transaksi cepat dengan scan barcode atau input manual.  
   - Dukungan diskon per item atau total pembelian.  
   - Opsi pembayaran tunai, kartu, atau dompet digital dengan integrasi API pembayaran (opsional).  

✅ **Laporan Penjualan**  
   - Filter laporan berdasarkan tanggal, kategori, atau kasir.  
   - Ekspor laporan ke PDF, Excel, atau CSV.  
   - Analisis keuntungan dan kerugian harian/mingguan/bulanan.  

✅ **Struk & Faktur**  
   - Struk digital yang dapat dikirim via email atau WhatsApp.  
   - Cetak struk langsung ke printer thermal (kompatibel dengan ESC/POS).  
   - Kustomisasi template struk dengan logo bisnis.  

✅ **Manajemen Stok**  
   - Peringatan otomatis saat stok menipis di bawah batas minimum.  
   - Riwayat perubahan stok untuk audit dan pelacakan.  
   - Fitur penyesuaian stok (misalnya untuk barang rusak atau hilang).  

✅ **Multi User & Hak Akses**  
   - Role-based access: Admin (penuh), Kasir (transaksi saja), dan Manajer (laporan + pengaturan).  
   - Log aktivitas pengguna untuk keamanan dan akuntabilitas.  

✅ **Pengaturan Sistem**  
   - Konfigurasi pajak (PPN atau lainnya) sesuai kebutuhan bisnis.  
   - Pengelolaan informasi toko (nama, alamat, kontak).  
   - Pilihan bahasa dan mata uang untuk fleksibilitas internasional.  

✅ **Integrasi Tambahan**  
   - Sinkronisasi dengan aplikasi akuntansi (misalnya: Xero, QuickBooks).  
   - API untuk integrasi dengan sistem POS eksternal atau e-commerce.  
   - Backup otomatis ke cloud untuk keamanan data.  

## 🚀 Keunggulan KasirOrb

- **Performa Cepat**: Dibangun dengan Laravel untuk efisiensi dan skalabilitas.  
- **Desain Modern**: Antarmuka berbasis Tailwind CSS yang responsif di desktop dan mobile.  
- **Open Source**: Gratis untuk digunakan dan dikembangkan oleh komunitas.  
- **Kustomisasi Mudah**: Struktur kode yang rapi dan dokumentasi lengkap.  

## 🛠️ Prasyarat Instalasi

- PHP >= 8.1  
- Composer  
- MySQL atau database lain yang didukung Laravel  
- Node.js & NPM (untuk Tailwind CSS)  
- Server web (Apache/Nginx)  

## 📦 Cara Instalasi

1. Clone repository ini:
   ```bash
   git clone https://github.com/maousamaNatz/Kasir.git
   ```
2. Masuk ke direktori proyek:
   ```bash
   cd kasirorb
   ```
3. Install dependensi PHP:
   ```bash
   composer install
   ```
4. Install dependensi frontend:
   ```bash
   npm install && npm run dev
   ```
5. Salin file `.env.example` ke `.env` dan sesuaikan konfigurasi database:
   ```bash
   cp .env.example .env
   ```
6. Generate application key:
   ```bash
   php artisan key:generate
   ```
7. Jalankan migrasi database:
   ```bash
   php artisan migrate
   ```
8. Jalankan aplikasi:
   ```bash
   php artisan serve
   ```

## 🤝 Kontribusi

Kami menyambut kontribusi dari siapa saja! Untuk berkontribusi:
1. Fork repository ini.  
2. Buat branch fitur Anda (`git checkout -b fitur-anda`).  
3. Commit perubahan Anda (`git commit -m 'Menambahkan fitur X'`).  
4. Push ke branch Anda (`git push origin fitur-anda`).  
5. Buat Pull Request di GitHub.  

Silakan baca [CONTRIBUTING.md](CONTRIBUTING.md) untuk detail lebih lanjut.

## 📄 Lisensi

**KasirOrb** dilisensikan di bawah [MIT License](LICENSE.md). Anda bebas menggunakan, memodifikasi, dan mendistribusikan aplikasi ini sesuai ketentuan lisensi.
