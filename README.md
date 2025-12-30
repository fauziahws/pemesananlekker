# 🍽️ Sistem Pemesanan Lekker

Aplikasi web pemesanan makanan dan minuman berbasis Laravel 11 dengan fitur lengkap untuk Customer, Cashier, dan Superadmin.

## 📋 Fitur Utama

### Customer

-   ✅ Lihat menu produk dengan gambar
-   ✅ Tambah produk ke keranjang
-   ✅ Checkout pesanan dengan nama pemesan dan nomor meja
-   ✅ Lihat struk pesanan setelah checkout
-   ✅ Riwayat pesanan

### Cashier

-   ✅ Lihat daftar pesanan pending dan processing
-   ✅ Update status pesanan (pending → processing → completed)
-   ✅ Tandai pesanan sudah dibayar
-   ✅ Lihat detail pesanan lengkap

### Superadmin

-   ✅ CRUD produk dengan upload gambar
-   ✅ CRUD user dan manajemen role
-   ✅ Dashboard statistik
-   ✅ Monitor semua pesanan

## 🛠️ Teknologi

-   **Framework:** Laravel 11
-   **PHP:** 8.2+
-   **Database:** MySQL
-   **Frontend:** Blade + Tailwind CSS (via Laravel Breeze)
-   **Authentication:** Laravel Breeze
-   **Storage:** Public disk untuk upload gambar

## 📦 Instalasi

### Requirements

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL

### Langkah Instalasi

1. **Clone atau copy project ini**

    ```bash
    cd pemesananlekker
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Setup environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Konfigurasi database di `.env`**

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=lekker_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Create database**

    ```bash
    mysql -u root -p
    CREATE DATABASE lekker_db;
    exit;
    ```

6. **Run migrations dan seeders**

    ```bash
    php artisan migrate --seed
    ```

7. **Setup storage link**

    ```bash
    php artisan storage:link
    ```

8. **Download sample product images (opsional)**

    ```bash
    chmod +x download-sample-images.sh
    ./download-sample-images.sh
    ```

9. **Build frontend assets**

    ```bash
    npm run build
    # atau untuk development dengan hot reload:
    npm run dev
    ```

10. **Start development server**

    ```bash
    php artisan serve
    ```

11. **Akses aplikasi**
    - URL: `http://localhost:8000`

## 👤 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

| Role           | Email                | Password |
| -------------- | -------------------- | -------- |
| **Superadmin** | admin@example.com    | password |
| **Cashier**    | cashier@example.com  | password |
| **Customer**   | customer@example.com | password |

## 📁 Struktur Database

### Tables

#### `users`

-   id, name, email, password, role (customer/cashier/superadmin), timestamps

#### `products`

-   id, name, description, price, image, is_available, timestamps

#### `orders`

-   id, order_code, user_id, customer_name, table_number, total_amount, status (pending/processing/completed/cancelled), paid, timestamps

#### `order_items`

-   id, order_id, product_id, quantity, price, total, timestamps

## 🔌 API Endpoints

### Products

```http
GET /api/products
```

Response:

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Nasi Goreng Spesial",
            "description": "...",
            "price": "25000.00",
            "image_url": "http://localhost:8000/storage/products/sample-1.jpg",
            "is_available": true
        }
    ]
}
```

### Cart

```http
POST /api/cart/add
Content-Type: application/json

{
  "product_id": 1,
  "quantity": 2
}
```

```http
POST /api/cart/update
Content-Type: application/json

{
  "product_id": 1,
  "quantity": 3
}
```

### Orders

```http
POST /api/orders
Content-Type: application/json

{
  "customer_name": "John Doe",
  "table_number": "A5",
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    },
    {
      "product_id": 3,
      "quantity": 1
    }
  ]
}
```

Response:

```json
{
    "success": true,
    "message": "Pesanan berhasil dibuat.",
    "data": {
        "order_code": "ORD-ABC12345",
        "total_amount": "80000.00",
        "status": "pending"
    }
}
```

## 🎨 Routing

### Public Routes

-   `GET /` - Redirect ke menu
-   `GET /login` - Halaman login
-   `GET /register` - Halaman register

### Authenticated Routes

-   `GET /dashboard` - Auto-redirect berdasarkan role
-   `GET /menu` - Daftar produk
-   `GET /cart` - Keranjang belanja
-   `GET /orders/checkout` - Halaman checkout
-   `GET /orders/{order}/receipt` - Struk pesanan

### Cashier Routes (role: cashier, superadmin)

-   `GET /cashier/orders` - Daftar pesanan aktif
-   `GET /cashier/orders/{order}` - Detail pesanan
-   `PATCH /cashier/orders/{order}/status` - Update status pesanan
-   `PATCH /cashier/orders/{order}/paid` - Tandai sudah dibayar

### Admin Routes (role: superadmin)

-   `GET /admin/dashboard` - Dashboard admin
-   `GET /admin/products` - CRUD produk
-   `GET /admin/users` - CRUD user
-   `GET /admin/orders` - Monitor pesanan

## 📸 Upload Gambar Produk

Gambar produk disimpan di `storage/app/public/products/`.

### Validasi:

-   Format: JPEG, PNG, WebP
-   Max size: 2MB
-   Otomatis delete file lama saat update/delete produk

### Cara upload manual:

1. Copy gambar ke `storage/app/public/products/`
2. Update database: `image` field dengan path relatif (misal: `products/nasi-goreng.jpg`)
3. Gambar dapat diakses via `Storage::url($product->image)`

## 🚀 Development

### Menjalankan tests

```bash
php artisan test
```

### Format code

```bash
./vendor/bin/pint
```

### Clear cache

```bash
php artisan optimize:clear
```

## 📝 Catatan

-   **Storage Link:** Pastikan `php artisan storage:link` sudah dijalankan agar gambar produk dapat diakses
-   **Sample Images:** Script `download-sample-images.sh` menggunakan picsum.photos untuk placeholder
-   **Environment:** Untuk production, jangan lupa set `APP_ENV=production` dan `APP_DEBUG=false` di `.env`
-   **CSRF Protection:** Semua form POST/PUT/DELETE sudah dilengkapi `@csrf` token

## 🔒 Security

-   Password di-hash menggunakan bcrypt
-   CSRF protection aktif
-   SQL injection prevention via Eloquent ORM
-   XSS protection via Blade templating
-   Role-based access control (middleware)

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Credits

Developed with ❤️ using Laravel 11 & Tailwind CSS

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
