<?php
namespace App\Models;

use Core\Database;

// Model untuk mengelola data Siswa
class Siswa
{
    // Mengambil semua data siswa beserta informasi kelas
    public static function all(): array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Query untuk mengambil data siswa dan join dengan tabel kelas
        $stmt = $pdo->query('SELECT s.*, k.nama_kelas, k.tingkat FROM siswa s JOIN kelas k ON s.id_kelas = k.id_kelas ORDER BY s.nama_siswa ASC');
        // Kembalikan hasil sebagai array
        return $stmt->fetchAll();
    }

    // Mencari siswa berdasarkan NIS
    public static function find(string $nis): ?array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query select berdasarkan NIS
        $stmt = $pdo->prepare('SELECT * FROM siswa WHERE nis = :nis');
        // Eksekusi query dengan parameter NIS
        $stmt->execute([':nis' => $nis]);
        // Ambil satu baris hasil
        $row = $stmt->fetch();
        // Kembalikan hasil atau null jika tidak ditemukan
        return $row ?: null;
    }

    // Menambahkan data siswa baru
    public static function create(string $nis, int $id_kelas, string $nama_siswa, string $jekel, string $alamat): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query insert
        $stmt = $pdo->prepare('INSERT INTO siswa (nis, id_kelas, nama_siswa, jekel, alamat) VALUES (:nis, :id_kelas, :nama, :jekel, :alamat)');
        // Eksekusi query dengan data yang diberikan
        return $stmt->execute([
            ':nis' => $nis,
            ':id_kelas' => $id_kelas,
            ':nama' => $nama_siswa,
            ':jekel' => $jekel,
            ':alamat' => $alamat
        ]);
    }

    // Memperbarui data siswa
    public static function update(string $nis, int $id_kelas, string $nama_siswa, string $jekel, string $alamat): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query update
        $stmt = $pdo->prepare('UPDATE siswa SET id_kelas = :id_kelas, nama_siswa = :nama, jekel = :jekel, alamat = :alamat WHERE nis = :nis');
        // Eksekusi query dengan data baru
        return $stmt->execute([
            ':nis' => $nis,
            ':id_kelas' => $id_kelas,
            ':nama' => $nama_siswa,
            ':jekel' => $jekel,
            ':alamat' => $alamat
        ]);
    }

    // Menghapus data siswa
    public static function delete(string $nis): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query delete
        $stmt = $pdo->prepare('DELETE FROM siswa WHERE nis = :nis');
        // Eksekusi query hapus
        return $stmt->execute([':nis' => $nis]);
    }
}
