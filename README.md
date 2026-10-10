# Tugas Rutin 11: Advanced Eloquent ORM, Breeze Multi-Role Auth, & Filament Admin Panel

**Mata Kuliah:** 3KOM40115 - Pemrograman Web  
**Dosen Pengampu:** Adidtya Perdana, S.T., M.Kom  
**Program Studi:** Ilmu Komputer - FMIPA UNIMED  
**Repositori:** [TugasWeb-P11-EcommerceAuth](https://github.com/Naufal0620/TugasWeb-P11-EcommerceAuth)

---

## 📌 Deskripsi Proyek
Proyek ini merupakan implementasi terpadu Tugas Rutin 11 mata kuliah Pemrograman Web yang menggabungkan:
1. **Bagian A: Database & Advanced Eloquent ORM** — Skema relasional 7 tabel E-Commerce, Database Migrations, Foreign Key Constraints, Factories & Seeders (55+ data produk realistis + kategori + tags + transaksi), Eloquent Relationships (`hasMany`, `belongsTo`, `belongsToMany`), dan Local Query Scopes.
2. **Bagian B: Secure Auth & Access Control** — Otentikasi Laravel Breeze, Multi-Role Access (`admin`, `editor`, `user`), Custom Middleware `CheckRole`, Otorisasi Policy (`ProductPolicy`), dan Integrasi Dashboard Otomatis **Filament Admin Panel v3**.

---

## 🏗️ Struktur Skema Database (7 Tabel E-Commerce)
1. **`users`**: Data pengguna, kredensial login, dan atribut `role` (`admin`, `editor`, `user`).
2. **`categories`**: Kategori produk (`name`, `slug`, `description`).
3. **`products`**: Data produk e-commerce (`category_id`, `user_id`, `image`, `title`, `slug`, `description`, `price`, `stock`, `is_active`).
4. **`orders`**: Transaksi pemesanan (`user_id`, `order_number`, `total_amount`, `status`).
5. **`order_items`**: Detail item produk dalam pesanan (`order_id`, `product_id`, `quantity`, `price`).
6. **`tags`**: Label / penanda produk (`name`, `slug`).
7. **`product_tag`**: Pivot table Many-to-Many antara `products` dan `tags` dengan unique constraint index.

---

## 🧪 5 Query Wajib Dokumentasi Laravel Tinker
Berikut adalah 5 query Eloquent ORM yang diuji melalui REPL `php artisan tinker`:

```php
// 1. Menghitung total seluruh produk dalam database
>>> Product::count();
// Output: 55

// 2. Mengambil record produk pertama dengan eager loading relasi kategori (bebas N+1 Problem)
>>> Product::with('category')->first();

// 3. Menghitung jumlah transaksi pesanan (orders) yang dimiliki oleh user
>>> User::where('role', 'user')->first()->orders->count();

// 4. Subquery agregasi menghitung kalkulasi total pesanan pertama
>>> Order::withSum('items as total_calculated', 'price')->first();

// 5. Query relasi bersarang memfilter seluruh produk pada kategori 'Elektronik'
>>> Product::whereRelation('category', 'name', 'Elektronik')->get();
```

---

## 🔐 Akun Default Pengujian Multi-Role

| Role | Nama Pengguna | Alamat Email | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- | :--- |
| **Admin** | Super Administrator | `admin@unimed.ac.id` | `password123` | Akses penuh CRUD, Route Admin, Filament Panel `/admin` |
| **Editor** | Content Editor | `editor@unimed.ac.id` | `password123` | Membuat dan memperbarui produk, dilarang hapus produk & dilarang akses `/admin` |
| **User** | Regular Customer | `user@unimed.ac.id` | `password123` | Melihat katalog, hanya boleh mengedit produk milik sendiri jika ada |

---

## 🛡️ Keamanan, Middleware, & Policy
- **Middleware `CheckRole`:** Mencegah akses route `/admin/dashboard` dan resource penting jika role pengguna tidak terdaftar (mengembalikan response `403 Forbidden`).
- **Policy `ProductPolicy`:**
  - `create`: Hanya `admin` dan `editor`.
  - `update`: `admin`, `editor`, atau pemilik produk (`user_id`).
  - `delete`: Khusus wewenang `admin`.
- **Filament User Interface:** Implementasi kontrak `FilamentUser` pada model `User` (`canAccessPanel()`) memastikan hanya role `admin` yang dapat mengakses panel admin Filament v3.

---

## 🚀 Panduan Instalasi & Menjalankan

### Menggunakan DDEV:
```bash
# 1. Clone repositori
git clone https://github.com/Naufal0620/TugasWeb-P11-EcommerceAuth.git
cd TugasWeb-P11-EcommerceAuth

# 2. Start DDEV
ddev start

# 3. Jalankan migrasi dan seeding data (55+ Produk & Akun)
ddev artisan migrate:fresh --seed
ddev artisan storage:link

# 4. Akses Web & Filament Panel
# Web Frontend: http://tugasweb-p11-ecommerceauth.ddev.site
# Filament Panel: http://tugasweb-p11-ecommerceauth.ddev.site/admin
```

### Menggunakan PHP Standar / Composer:
```bash
# 1. Clone repositori
git clone https://github.com/Naufal0620/TugasWeb-P11-EcommerceAuth.git
cd TugasWeb-P11-EcommerceAuth

# 2. Install dependensi
composer install
npm install && npm run build

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Migrasi dan Seeding
php artisan migrate:fresh --seed
php artisan storage:link

# 5. Jalankan web server
php artisan serve
```
