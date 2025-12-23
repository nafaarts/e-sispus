# e-perpus

Aplikasi perpustakaan sekolah berbasis PHP yang menerapkan arsitektur MVC sederhana. Fitur inti mencakup:
- Manajemen pengguna (`ADMIN` dan `OPERATOR`)
- Manajemen kelas, siswa, rak, dan buku
- Peminjaman dan pengembalian buku, termasuk detail peminjaman dan status
- Proteksi CSRF pada semua form dan flash session untuk validasi

Struktur inti aplikasi:
- Entry point: `public/index.php` (routing sederhana: `controller/method/params`)
- Lapisan inti: `core/` (Autoloader, Session, Env, Config, Database, Auth, Csrf)
- Controller: `app/Controllers/*`
- Model: `app/Models/*` (menggunakan `Core\Database`/PDO)
- View: `app/Views/*` (Bootstrap untuk UI)
- Docker env: `docker/` (nginx, php-fpm, mysql + seed)

Konfigurasi database dibaca dari `.env` melalui `Core\Config`:
- `DB_CONNECTION` (`mysql` atau `pgsql`, default `mysql`)
- `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_CHARSET`

## Prasyarat
- PHP 8.1+ (disarankan 8.3 untuk lingkungan dev)
- Ekstensi `pdo` + `pdo_mysql` (atau `pdo_pgsql` jika pakai PostgreSQL)
- Web server yang mengarah ke `public/` (Nginx/Apache)
- MariaDB/MySQL (default), atau PostgreSQL jika dikonfigurasi

## Konfigurasi `.env`
Buat file `.env` di root proyek:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=perpus
DB_USER=root
DB_PASS=
DB_CHARSET=utf8mb4
```

## Akun Default
Seed bawaan berada di `docker/mysql/init.sql`:
- Admin: `admin / password`
- Operator: `operator / password`

## Instalasi dengan Docker

1) Siapkan file `.env` seperti di atas.
2) Buat `docker-compose.yml` di root proyek (contoh minimal):
```
version: "3.8"
services:
  php:
    build: ./docker/php
    volumes:
      - ./:/var/www/html
    networks:
      - appnet
  nginx:
    image: nginx:alpine
    volumes:
      - ./:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    ports:
      - "8080:80"
    depends_on:
      - php
    networks:
      - appnet
  mysql:
    image: mysql:8
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: perpus
    volumes:
      - dbdata:/var/lib/mysql
      - ./docker/mysql/init.sql:/docker-entrypoint-initdb.d/init.sql
    ports:
      - "3307:3306"
    networks:
      - appnet
networks:
  appnet:
volumes:
  dbdata:
```
3) Jalankan:
```
docker compose up -d --build
```
4) Akses aplikasi di `http://localhost:8080/`.

Catatan:
- Nginx sudah dikonfigurasi untuk root `public/` dan `try_files` ke `index.php`.
- Pastikan `.env` disesuaikan dengan kredensial MySQL container (`DB_HOST=mysql`, `DB_USER=root`, `DB_PASS=root`, `DB_NAME=perpus`, `DB_PORT=3306`).

## Instalasi dengan Laragon (Windows)

1) Install Laragon dan pastikan PHP, Apache, dan MySQL aktif.
2) Clone atau salin proyek ke folder `Laragon/www/e-perpus`.
3) Konfigurasi `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=perpus
DB_USER=root
DB_PASS=
```
4) Buat database `perpus` di MySQL Laragon (via HeidiSQL atau phpMyAdmin).
5) Import schema + seed dari `docker/mysql/init.sql` ke database `perpus`.
6) Pastikan Document Root mengarah ke `public/`:
   - Jika menggunakan virtual host Laragon, set Document Root ke `e-perpus/public`.
7) Buka `http://e-perpus.test/` (atau `http://localhost/e-perpus/public/` jika tanpa vhost).

## Instalasi dengan XAMPP (Windows/Mac/Linux)

1) Install XAMPP dan start `Apache` serta `MySQL`.
2) Salin proyek ke `htdocs/e-perpus`.
3) Konfigurasi `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=perpus
DB_USER=root
DB_PASS=
```
4) Buat database `perpus` via phpMyAdmin (`http://localhost/phpmyadmin`).
5) Import `docker/mysql/init.sql` ke database `perpus`.
6) Akses aplikasi:
   - `http://localhost/e-perpus/public/`
   - Jika ingin tanpa `/public`, set Document Root Apache ke folder `public/` atau buat alias/vhost.

## Catatan Keamanan & Produksi
- Ganti kredensial default dan hash password sesuai kebijakan.
- Nonaktifkan display errors di produksi.
- Pastikan `public/` adalah satu-satunya directory yang dapat diakses web.
- Backup database secara berkala; jalankan migrasi/seed terkontrol.

## Troubleshooting
- Jika muncul error koneksi DB, cek `Config.php` dan nilai `.env`.
- Jika URL tidak ter-*route*, pastikan web server mengarah ke `public/` dan `try_files`/`Rewrite` aktif.
- Pastikan ekstensi `pdo_mysql` terpasang (Dockerfile sudah mengaktifkan).
