<?php
namespace App\Models;

use Core\Database;

// Model untuk mengelola data Rak Buku
class Rak
{
    // Mengambil semua data rak beserta jumlah buku di dalamnya
    public static function all(): array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Query untuk mengambil data rak dan menghitung jumlah buku per rak
        $stmt = $pdo->query('
            SELECT r.*, 
                   (SELECT COUNT(*) FROM buku b WHERE b.id_rak = r.id_rak) AS jumlah_buku
            FROM rak r
            ORDER BY r.nama_rak ASC
        ');
        // Kembalikan hasil sebagai array
        return $stmt->fetchAll();
    }

    // Mencari rak berdasarkan ID
    public static function find(int $id): ?array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query select berdasarkan ID
        $stmt = $pdo->prepare('SELECT * FROM rak WHERE id_rak = :id');
        // Eksekusi query dengan parameter ID
        $stmt->execute([':id' => $id]);
        // Ambil satu baris hasil
        $row = $stmt->fetch();
        // Kembalikan hasil atau null jika tidak ditemukan
        return $row ?: null;
    }

    // Menambahkan data rak baru
    public static function create(string $nama_rak, string $lokasi): int
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query insert
        $stmt = $pdo->prepare('INSERT INTO rak (nama_rak, lokasi) VALUES (:nama, :lokasi)');
        // Eksekusi query dengan data yang diberikan
        $stmt->execute([':nama' => $nama_rak, ':lokasi' => $lokasi]);
        // Kembalikan ID dari data yang baru ditambahkan
        return (int)$pdo->lastInsertId();
    }

    // Memperbarui data rak
    public static function update(int $id, string $nama_rak, string $lokasi): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query update
        $stmt = $pdo->prepare('UPDATE rak SET nama_rak = :nama, lokasi = :lokasi WHERE id_rak = :id');
        // Eksekusi query dengan data baru
        return $stmt->execute([':nama' => $nama_rak, ':lokasi' => $lokasi, ':id' => $id]);
    }

    // Menghapus data rak
    public static function delete(int $id): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query delete
        $stmt = $pdo->prepare('DELETE FROM rak WHERE id_rak = :id');
        // Eksekusi query hapus
        return $stmt->execute([':id' => $id]);
    }
}
