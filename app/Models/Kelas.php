<?php
namespace App\Models;

use Core\Database;

// Model untuk mengelola data Kelas
class Kelas
{
    // Mengambil semua data kelas
    public static function all(): array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Query untuk mengambil semua data kelas diurutkan berdasarkan tingkat dan nama
        $stmt = $pdo->query('SELECT * FROM kelas ORDER BY tingkat ASC, nama_kelas ASC');
        // Kembalikan hasil sebagai array
        return $stmt->fetchAll();
    }

    // Mencari kelas berdasarkan ID
    public static function find(int $id): ?array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query select berdasarkan ID
        $stmt = $pdo->prepare('SELECT * FROM kelas WHERE id_kelas = :id');
        // Eksekusi query dengan parameter ID
        $stmt->execute([':id' => $id]);
        // Ambil satu baris hasil
        $row = $stmt->fetch();
        // Kembalikan hasil atau null jika tidak ditemukan
        return $row ?: null;
    }

    // Menambahkan data kelas baru
    public static function create(string $nama_kelas, int $tingkat): int
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query insert
        $stmt = $pdo->prepare('INSERT INTO kelas (nama_kelas, tingkat) VALUES (:nama, :tingkat)');
        // Eksekusi query dengan data yang diberikan
        $stmt->execute([':nama' => $nama_kelas, ':tingkat' => $tingkat]);
        // Kembalikan ID dari data yang baru ditambahkan
        return (int)$pdo->lastInsertId();
    }

    // Memperbarui data kelas
    public static function update(int $id, string $nama_kelas, int $tingkat): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query update
        $stmt = $pdo->prepare('UPDATE kelas SET nama_kelas = :nama, tingkat = :tingkat WHERE id_kelas = :id');
        // Eksekusi query dengan data baru
        return $stmt->execute([':nama' => $nama_kelas, ':tingkat' => $tingkat, ':id' => $id]);
    }

    // Menghapus data kelas
    public static function delete(int $id): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query delete
        $stmt = $pdo->prepare('DELETE FROM kelas WHERE id_kelas = :id');
        // Eksekusi query hapus
        return $stmt->execute([':id' => $id]);
    }
}
