<?php
namespace Core;

use PDO;

// Kelas Database menggunakan pola Singleton untuk koneksi database
class Database
{
    // Property statis untuk menyimpan instance singleton
    private static ?Database $instance = null;
    // Property untuk menyimpan objek PDO
    private PDO $pdo;

    // Constructor privat agar tidak bisa diinstansiasi langsung dari luar
    private function __construct()
    {
        // Mengambil konfigurasi database
        $dsn = Config::get('db.dsn');
        $user = Config::get('db.user');
        $pass = Config::get('db.pass');
        $options = Config::get('db.options');
        // Membuat koneksi PDO baru
        $this->pdo = new PDO($dsn, $user, $pass, $options);
    }

    // Fungsi statis untuk mendapatkan instance Database (Singleton Pattern)
    public static function getInstance(): Database
    {
        // Jika instance belum ada, buat baru
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        // Kembalikan instance yang ada
        return self::$instance;
    }

    // Fungsi untuk mendapatkan objek PDO
    public function pdo(): PDO
    {
        return $this->pdo;
    }
}

