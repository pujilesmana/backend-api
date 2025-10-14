<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Backend API - Laravel

Backend API ini dibangun menggunakan [Laravel](https://laravel.com), framework PHP yang powerful dan mudah digunakan.

## Prasyarat

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & npm (untuk asset frontend jika diperlukan)

## Setup & Instalasi

1. **Clone repository**
   ```sh
   git clone <repo-url>
   cd backend-api
   ```

2. **Install dependency PHP**
   ```sh
   composer install
   ```

3. **Copy file environment**
   ```sh
   cp .env.example .env
   ```

4. **Generate APP_KEY**
   ```sh
   php artisan key:generate
   ```

5. **Setup Database**
   - Buat database baru di MySQL, misal: `pmi-database`
   - Edit file `.env` sesuai konfigurasi database Anda:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=pmi-database
     DB_USERNAME=root
     DB_PASSWORD=password
     ```

6. **Jalankan migrasi**
   ```sh
   php artisan migrate
   ```

7. **Jalankan seeder**
   ```sh
   php artisan db:seed --class=UserSeeder
   ```

8. **Jalankan aplikasi**
   ```sh
   php artisan serve
   ```
   Aplikasi akan berjalan di [http://localhost:8000](http://localhost:8000)

## Running Command

- **Migrasi database**
  ```sh
  php artisan migrate
  ```
- **Menjalankan seeder**
  ```sh
  php artisan db:seed --class=UserSeeder
  ```
- **Menjalankan aplikasi**
  ```sh
  php artisan serve
  ```

## Struktur Folder

- `app/Models/User.php` - Model User
- `database/migrations/` - File migrasi database
- `database/seeders/UserSeeder.php` - Seeder data user
- `database/factories/UserFactory.php` - Factory user untuk seeder

## Lisensi

Proyek ini menggunakan [MIT license](https://opensource.org/licenses/MIT).
