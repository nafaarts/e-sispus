<?php
namespace Core;

// Kelas Request menangani data input dari pengguna (GET/POST)
class Request
{
    // Mengambil semua data dari $_POST dan $_GET
    public static function all(): array
    {
        // Menggabungkan array POST dan GET
        return $_POST + $_GET;
    }

    // Mengambil nilai input spesifik berdasarkan key
    public static function input(string $key, $default = null)
    {
        // Cek prioritas di POST
        if (array_key_exists($key, $_POST)) {
            return $_POST[$key];
        }
        // Cek di GET jika tidak ada di POST
        if (array_key_exists($key, $_GET)) {
            return $_GET[$key];
        }
        // Kembalikan nilai default jika tidak ditemukan
        return $default;
    }
}

