<?php
namespace Core;

use Core\Database;

// Kelas Auth menangani autentikasi dan otorisasi pengguna
class Auth
{
    // Fungsi untuk memproses login pengguna
    public static function login(string $email, string $password): bool
    {
        // Mendapatkan instance koneksi database
        $pdo = Database::getInstance()->pdo();
        // Mempersiapkan query untuk mencari user berdasarkan email
        $stmt = $pdo->prepare('SELECT id,username,name,email,password_hash,role FROM users WHERE email = :email LIMIT 1');
        // Menjalankan query dengan parameter email
        $stmt->execute([':email' => $email]);
        // Mengambil data user
        $user = $stmt->fetch();
        // Jika user tidak ditemukan, kembalikan false
        if (!$user) {
            return false;
        }
        // Verifikasi password yang diinput dengan hash di database
        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }
        // Memulai sesi
        Session::start();
        // Meregenerasi ID sesi untuk keamanan
        session_regenerate_id(true);
        // Menyimpan data user ke dalam sesi
        Session::set('user_id', (int)$user['id']);
        Session::set('user_role', $user['role']);
        Session::set('user_username', $user['username']);
        Session::set('user_name', $user['name']);
        Session::set('user_email', $user['email']);
        // Mengembalikan true jika login berhasil
        return true;
    }

    // Fungsi untuk logout pengguna
    public static function logout(): void
    {
        // Menghapus data user dari sesi
        Session::remove('user_id');
        Session::remove('user_role');
        Session::remove('user_username');
        Session::remove('user_name');
        Session::remove('user_email');
        // Menghancurkan sesi sepenuhnya
        Session::destroy();
    }

    // Fungsi untuk mengecek apakah pengguna sudah login
    public static function check(): bool
    {
        // Mengembalikan true jika ada user_id di sesi
        return (bool)Session::get('user_id');
    }

    // Fungsi untuk mendapatkan data pengguna yang sedang login
    public static function user(): ?array
    {
        // Jika belum login, kembalikan null
        if (!self::check()) {
            return null;
        }
        // Mengembalikan array data user dari sesi
        return [
            'id' => Session::get('user_id'),
            'username' => Session::get('user_username'),
            'name' => Session::get('user_name'),
            'email' => Session::get('user_email'),
            'role' => Session::get('user_role')
        ];
    }

    // Fungsi untuk mengecek izin akses (authorization)
    public static function can(string $permission): bool
    {
        // Jika belum login, tidak punya akses
        if (!self::check()) return false;
        // Ambil role dari sesi
        $role = (string)Session::get('user_role');
        // Admin memiliki semua akses
        if ($role === 'ADMIN') {
            return true;
        }
        // Daftar izin untuk operator
        $operatorPerms = [
            'manage_peminjaman'
        ];
        // Cek apakah permission ada di daftar izin operator
        return in_array($permission, $operatorPerms, true);
    }
}
