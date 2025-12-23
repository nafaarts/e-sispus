<?php
namespace Core;

// Kelas Middleware untuk menangani pengecekan akses sebelum eksekusi controller
class Middleware
{
    // Memastikan pengguna sudah login (authenticated)
    public static function ensureAuthenticated(): void
    {
        // Jika belum login, redirect ke halaman login
        if (!Auth::check()) {
            header('Location: /index.php?url=auth/login');
            exit;
        }
    }

    // Memastikan pengguna memiliki izin tertentu (authorization)
    public static function ensureCan(string $permission): void
    {
        // Jika tidak punya izin, tampilkan error 403 Forbidden
        if (!Auth::can($permission)) {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }
}
