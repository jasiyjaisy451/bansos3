# Sistem Informasi Distribusi Bansos Pendidikan

Sistem digital untuk manajemen dan pendistribusian bantuan sosial pendidikan kepada ribuan siswa berbasis web menggunakan Laravel.

## 🚀 Fitur Utama

- **Input Data Penerima**: Form lengkap untuk data siswa dan orang tua
- **Generate QR Code**: QR unik terenkripsi untuk setiap penerima
- **Verifikasi QR**: Scan QR code untuk validasi penerima
- **Penyaluran Barang**: Checklist distribusi seragam, sepatu, tas
- **Bukti PDF**: Generate bukti penerimaan resmi
- **Dashboard Admin**: Statistik dan monitoring real-time
- **Autentikasi**: Login sistem untuk admin/operator

## 🛠️ Teknologi

- **Backend**: Laravel 10+
- **Frontend**: Blade Template + Bootstrap 5
- **Database**: MySQL/PostgreSQL
- **PDF Generator**: DomPDF
- **QR Code**: Simple QrCode Laravel
- **Authentication**: Laravel UI

## 📦 Instalasi

1. Clone repository
```bash
git clone [repository-url]
cd bansos-pendidikan
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bansos_pendidikan
DB_USERNAME=root
DB_PASSWORD=
```

5. Migrasi dan seeding
```bash
php artisan migrate:fresh --seed
```

6. Jalankan aplikasi
```bash
php artisan serve
```

## 👤 Login Default

- **Admin**: admin@bansos.com / password123
- **Operator**: operator@bansos.com / operator123

## 🎯 Cara Penggunaan

### 1. Input Data Penerima
- Login ke sistem
- Pilih menu "Data Penerima" → "Tambah Penerima"
- Isi form lengkap data siswa
- Sistem otomatis generate QR code unik

### 2. Penyaluran Bantuan
- Pilih menu "Scan QR Code"
- Scan QR code penerima dengan scanner/HP
- Centang barang yang diterima (seragam, sepatu, tas)
- Update status penyaluran

### 3. Generate Bukti PDF
- Setelah penyaluran lengkap
- Klik "Cetak Bukti" untuk download PDF
- PDF berisi biodata, daftar barang, dan QR verifikasi

## 📊 Dashboard Features

- Total penerima terdaftar
- Jumlah yang sudah/belum menerima
- Statistik per jenis barang
- Progress penyaluran real-time
- Riwayat distribusi terbaru

## 🔒 Keamanan

- QR code terenkripsi dengan base64
- Autentikasi wajib untuk akses sistem
- Validasi input dan CSRF protection
- Session management Laravel

## 🧪 Testing QR Code

QR code dapat di-scan menggunakan:
- Scanner barcode bluetooth
- Aplikasi scanner HP
- Input manual kode QR

Format QR: `base64_encode(qr_code|recipient_id)`

## 📱 Responsive Design

- Mobile-friendly interface
- Bootstrap 5 responsive grid
- Touch-friendly buttons
- Optimized untuk tablet/smartphone

## 🎨 UI/UX Features

- Pertamina corporate colors
- Intuitive navigation
- Real-time feedback
- Loading indicators
- Success/error notifications

## 📄 PDF Output

Bukti penerimaan PDF berisi:
- Header Bazma Pertamina
- Biodata lengkap penerima
- Checklist barang diterima
- QR code verifikasi
- Kolom tanda tangan
- Footer informasi program

## 🔧 Troubleshooting

### QR Code tidak terbaca
- Pastikan QR code tidak rusak/blur
- Coba input manual kode QR
- Periksa pencahayaan saat scan

### Error saat update penyaluran
- Refresh halaman dan coba lagi
- Periksa koneksi internet
- Logout dan login kembali

### PDF tidak generate
- Pastikan semua barang sudah dicentang
- Periksa permission folder storage
- Clear cache: `php artisan cache:clear`

## 📞 Support

Untuk bantuan teknis atau pertanyaan, hubungi tim development.

---

**© 2025 Bazma Pertamina - Sistem Bansos Pendidikan**