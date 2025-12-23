<?php
namespace Core;

// Kelas Helper untuk manajemen Session PHP
class Session
{
    // Memulai sesi jika belum aktif
    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    // Menyimpan nilai ke dalam sesi
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    // Mengambil nilai dari sesi, atau default jika tidak ada
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    // Menghapus item tertentu dari sesi
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    // Menghancurkan seluruh sesi (logout)
    public static function destroy(): void
    {
        // Kosongkan array session
        $_SESSION = [];
        // Hancurkan session jika aktif
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    // Menyimpan flash message (pesan sekali tampil)
    public static function setFlash(string $key, $value): void
    {
        self::start();
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
        $_SESSION['flash'][$key] = $value;
    }

    // Mengecek ketersediaan flash message
    public static function hasFlash(string $key): bool
    {
        self::start();
        return isset($_SESSION['flash'][$key]);
    }

    // Mengambil flash message dan langsung menghapusnya
    public static function getFlash(string $key, $default = null)
    {
        self::start();
        $value = $_SESSION['flash'][$key] ?? $default;
        // Hapus pesan setelah diambil agar tidak muncul lagi
        if (isset($_SESSION['flash'][$key])) {
            unset($_SESSION['flash'][$key]);
        }
        return $value;
    }
}
