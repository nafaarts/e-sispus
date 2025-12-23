<?php
namespace Core;

// Kelas Csrf untuk menangani proteksi Cross-Site Request Forgery
class Csrf
{
    // Fungsi untuk membuat atau mendapatkan token CSRF yang valid
    public static function token(): string
    {
        // Memastikan sesi aktif
        Session::start();
        // Cek apakah sudah ada token di sesi
        $token = Session::get('_csrf');
        // Jika belum ada, buat token baru secara acak
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            // Simpan token ke dalam sesi
            Session::set('_csrf', $token);
        }
        // Kembalikan token
        return $token;
    }

    // Fungsi untuk memverifikasi token CSRF yang dikirim
    public static function check(?string $token): bool
    {
        // Ambil token dari sesi saat ini
        $current = Session::get('_csrf', '');
        // Bandingkan token input dengan token sesi menggunakan perbandingan aman
        return $token !== null && $current !== '' && hash_equals($current, $token);
    }

    // Helper untuk membuat input hidden berisi token CSRF
    public static function field(): string
    {
        // Dapatkan token
        $token = self::token();
        // Kembalikan tag input HTML
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
