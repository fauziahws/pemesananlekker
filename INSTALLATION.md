# 🚀 Quick Start Guide - Lekker Ordering System

## Prerequisites

Pastikan sudah terinstall:

-   PHP 8.2 atau lebih tinggi
-   Composer
-   Node.js & NPM
-   MySQL
-   Git (opsional)

## Installation Steps

### 1. Persiapan Project

```bash
# Jika menggunakan Git
git clone <repository-url>
cd pemesananlekker

# Atau jika manual copy, langsung masuk ke folder
cd pemesananlekker
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan konfigurasi MySQL Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lekker_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Buat Database

```bash
# Login ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE lekker_db;
exit;
```

### 6. Run Migrations & Seeders

```bash
# Jalankan migrations dan seeders sekaligus
php artisan migrate --seed
```

Output yang diharapkan:

```
✓ Sample users created (admin@example.com, cashier@example.com, customer@example.com) - password: password
✓ Sample products created
⚠ Product images are set to placeholder paths...
```

### 7. Setup Storage

```bash
# Buat symbolic link untuk storage
php artisan storage:link
```

### 8. Download Sample Images (Opsional)

```bash
# Beri permission execute pada script
chmod +x download-sample-images.sh

# Jalankan script untuk download sample images
./download-sample-images.sh
```

Atau jika di Windows, copy manual gambar ke `storage/app/public/products/`

### 9. Build Frontend Assets

```bash
# Untuk production
npm run build

# Atau untuk development dengan hot reload
npm run dev
```

### 10. Start Development Server

```bash
# Di terminal baru (jika npm run dev masih running)
php artisan serve
```

### 11. Akses Aplikasi

Buka browser dan akses: `http://localhost:8000`

## Default Accounts

Login menggunakan salah satu akun berikut:

| Role           | Email                | Password | Akses          |
| -------------- | -------------------- | -------- | -------------- |
| **Superadmin** | admin@example.com    | password | Full access    |
| **Cashier**    | cashier@example.com  | password | Kelola pesanan |
| **Customer**   | customer@example.com | password | Pesan menu     |

**💡 Catatan:** User baru yang mendaftar via form register otomatis mendapat role **Customer**.

## Troubleshooting

### Error: "SQLSTATE[HY000] [2002] Connection refused"

**Solusi:** Pastikan MySQL sudah running

```bash
# macOS
brew services start mysql

# Linux
sudo service mysql start

# Windows
# Start MySQL via Services atau XAMPP
```

### Error: "The stream or file could not be opened"

**Solusi:** Set permission untuk storage dan bootstrap/cache

```bash
chmod -R 775 storage bootstrap/cache
```

### Gambar produk tidak muncul

**Solusi:**

1. Pastikan `php artisan storage:link` sudah dijalankan
2. Jalankan `./download-sample-images.sh` atau copy gambar manual
3. Cek permission folder `storage/app/public/products/`

### Error: "Vite manifest not found"

**Solusi:** Build frontend assets

```bash
npm run build
```

### Port 8000 sudah digunakan

**Solusi:** Gunakan port lain

```bash
php artisan serve --port=8001
```

## Next Steps

### 1. Explore sebagai Customer

-   Login sebagai customer@example.com
-   Lihat menu produk
-   Tambah ke keranjang
-   Checkout dan lihat struk

### 2. Test sebagai Cashier

-   Login sebagai cashier@example.com
-   Lihat pesanan pending
-   Update status pesanan
-   Tandai pesanan sudah dibayar

### 3. Manage sebagai Admin

-   Login sebagai admin@example.com
-   Tambah/edit/hapus produk
-   Upload gambar produk
-   Kelola user dan role
-   Monitor dashboard

## Development Commands

```bash
# Clear cache
php artisan optimize:clear

# Run tests
php artisan test

# Format code
./vendor/bin/pint

# Watch frontend changes
npm run dev

# Generate IDE helper (opsional)
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
```

## Production Deployment

Untuk production, jangan lupa:

1. Set environment variables di `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

2. Optimize application:

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Set proper file permissions:

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

4. Setup proper web server (Nginx/Apache)
5. Use queue worker untuk background jobs (jika ada)
6. Setup SSL certificate

## Need Help?

-   Check `README.md` untuk dokumentasi lengkap
-   Check `API_DOCUMENTATION.md` untuk API reference
-   Laravel Documentation: https://laravel.com/docs

---

Happy Coding! 🎉
