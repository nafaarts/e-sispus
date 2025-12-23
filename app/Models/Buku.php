<?php
namespace App\Models;

use Core\Database;

// Model untuk mengelola data Buku
class Buku
{
    // Mengambil semua data buku beserta informasi rak
    public static function all(): array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Query untuk mengambil data buku dan join dengan tabel rak
        $stmt = $pdo->query('SELECT b.*, r.nama_rak, r.lokasi FROM buku b JOIN rak r ON b.id_rak = r.id_rak ORDER BY b.judul_buku ASC');
        // Kembalikan hasil query sebagai array
        return $stmt->fetchAll();
    }

    // Mencari buku berdasarkan kode buku
    public static function find(string $kode): ?array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query select berdasarkan kode buku
        $stmt = $pdo->prepare('SELECT * FROM buku WHERE kode_buku = :kode');
        // Eksekusi query dengan parameter kode
        $stmt->execute([':kode' => $kode]);
        // Ambil satu baris hasil
        $row = $stmt->fetch();
        // Kembalikan hasil atau null jika tidak ditemukan
        return $row ?: null;
    }

    // Menambahkan data buku baru
    public static function create(string $kode, int $id_rak, string $judul, string $pengarang, string $penerbit, int $tahun, int $stok): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query insert
        $stmt = $pdo->prepare('INSERT INTO buku (kode_buku, id_rak, judul_buku, pengarang, penerbit, tahun_terbit, stok) VALUES (:kode, :id_rak, :judul, :pengarang, :penerbit, :tahun, :stok)');
        // Eksekusi query dengan data yang diberikan
        return $stmt->execute([
            ':kode' => $kode,
            ':id_rak' => $id_rak,
            ':judul' => $judul,
            ':pengarang' => $pengarang,
            ':penerbit' => $penerbit,
            ':tahun' => $tahun,
            ':stok' => $stok
        ]);
    }

    // Memperbarui data buku
    public static function update(string $kode, int $id_rak, string $judul, string $pengarang, string $penerbit, int $tahun, int $stok): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query update
        $stmt = $pdo->prepare('UPDATE buku SET id_rak = :id_rak, judul_buku = :judul, pengarang = :pengarang, penerbit = :penerbit, tahun_terbit = :tahun, stok = :stok WHERE kode_buku = :kode');
        // Eksekusi query dengan data baru
        return $stmt->execute([
            ':kode' => $kode,
            ':id_rak' => $id_rak,
            ':judul' => $judul,
            ':pengarang' => $pengarang,
            ':penerbit' => $penerbit,
            ':tahun' => $tahun,
            ':stok' => $stok
        ]);
    }

    // Menghapus data buku
    public static function delete(string $kode): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query delete
        $stmt = $pdo->prepare('DELETE FROM buku WHERE kode_buku = :kode');
        // Eksekusi query hapus
        return $stmt->execute([':kode' => $kode]);
    }

    // Mengurangi stok buku (misal saat dipinjam)
    public static function decrementStock(string $kode): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Update stok berkurang 1, pastikan stok > 0
        $stmt = $pdo->prepare('UPDATE buku SET stok = stok - 1 WHERE kode_buku = :kode AND stok > 0');
        // Eksekusi query
        return $stmt->execute([':kode' => $kode]);
    }

    // Menambah stok buku (misal saat dikembalikan)
    public static function incrementStock(string $kode): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Update stok bertambah 1
        $stmt = $pdo->prepare('UPDATE buku SET stok = stok + 1 WHERE kode_buku = :kode');
        // Eksekusi query
        return $stmt->execute([':kode' => $kode]);
    }
}
