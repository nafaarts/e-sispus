<?php
namespace Core;

// Kelas Config menangani konfigurasi aplikasi
class Config
{
    // Fungsi untuk mendapatkan nilai konfigurasi berdasarkan key (dot notation)
    public static function get(string $key, $default = null)
    {
        // Memecah key berdasarkan titik (contoh: db.host)
        $parts = explode('.', $key);
        // Mengambil semua konfigurasi
        $config = self::config();
        $value = $config;
        // Menelusuri array konfigurasi
        foreach ($parts as $part) {
            // Jika key tidak ditemukan, kembalikan default
            if (!is_array($value) || !array_key_exists($part, $value)) {
                return $default;
            }
            // Masuk ke level array berikutnya
            $value = $value[$part];
        }
        // Mengembalikan nilai konfigurasi yang ditemukan
        return $value;
    }

    // Fungsi internal yang mendefinisikan array konfigurasi
    protected static function config(): array
    {
        // Mengambil nilai dari environment variables atau default
        $driver = $_ENV['DB_CONNECTION'] ?? 'mysql';
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $port = $_ENV['DB_PORT'] ?? ($driver === 'pgsql' ? '5432' : '3306');
        $name = $_ENV['DB_NAME'] ?? 'app';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';
        $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

        // Membentuk DSN (Data Source Name) berdasarkan driver database
        $dsn = $driver === 'pgsql'
            ? "pgsql:host={$host};port={$port};dbname={$name}"
            : "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

        // Mengembalikan array konfigurasi lengkap
        return [
            'db' => [
                'driver' => $driver,
                'dsn' => $dsn,
                'user' => $user,
                'pass' => $pass,
                'options' => [
                    // Mode error exception agar mudah debugging
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    // Fetch mode default sebagai associative array
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    // Nonaktifkan emulasi prepared statements
                    \PDO::ATTR_EMULATE_PREPARES => false
                ]
            ]
        ];
    }
}

