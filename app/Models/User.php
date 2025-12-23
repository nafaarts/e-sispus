<?php
namespace App\Models;

use Core\Database;

// Model untuk mengelola data User (Pengguna)
class User
{
    // Mengambil semua data user
    public static function all(): array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Query untuk mengambil data user
        $stmt = $pdo->query('SELECT id,username,name,email,role FROM users ORDER BY id DESC');
        // Kembalikan hasil sebagai array
        return $stmt->fetchAll();
    }

    // Mencari user berdasarkan ID
    public static function find(int $id): ?array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query select berdasarkan ID
        $stmt = $pdo->prepare('SELECT id,username,name,email,role FROM users WHERE id = :id');
        // Eksekusi query dengan parameter ID
        $stmt->execute([':id' => $id]);
        // Ambil satu baris hasil
        $row = $stmt->fetch();
        // Kembalikan hasil atau null jika tidak ditemukan
        return $row ?: null;
    }

    // Mencari user berdasarkan Email
    public static function findByEmail(string $email): ?array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query select berdasarkan email
        $stmt = $pdo->prepare('SELECT id,username,name,email,role,password_hash FROM users WHERE email = :email');
        // Eksekusi query dengan parameter email
        $stmt->execute([':email' => $email]);
        // Ambil satu baris hasil
        $row = $stmt->fetch();
        // Kembalikan hasil atau null jika tidak ditemukan
        return $row ?: null;
    }

    // Mencari user berdasarkan Username
    public static function findByUsername(string $username): ?array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query select berdasarkan username
        $stmt = $pdo->prepare('SELECT id,username,name,email,role,password_hash FROM users WHERE username = :username');
        // Eksekusi query dengan parameter username
        $stmt->execute([':username' => $username]);
        // Ambil satu baris hasil
        $row = $stmt->fetch();
        // Kembalikan hasil atau null jika tidak ditemukan
        return $row ?: null;
    }

    // Menambahkan user baru
    public static function create(string $username, string $name, string $email, string $password, string $role): int
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Hash password sebelum disimpan
        $hash = password_hash($password, PASSWORD_BCRYPT);
        // Persiapkan query insert
        $stmt = $pdo->prepare('INSERT INTO users (username,name,email,password_hash,role) VALUES (:username,:name,:email,:hash,:role)');
        // Eksekusi query dengan data yang diberikan
        $stmt->execute([':username' => $username, ':name' => $name, ':email' => $email, ':hash' => $hash, ':role' => $role]);
        // Kembalikan ID user yang baru dibuat
        return (int)$pdo->lastInsertId();
    }

    // Memperbarui data user
    public static function update(int $id, string $username, string $name, string $email, ?string $password, string $role): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Jika password diisi, update password juga
        if ($password !== null && $password !== '') {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('UPDATE users SET username=:username,name=:name,email=:email,password_hash=:hash,role=:role WHERE id=:id');
            return $stmt->execute([':username' => $username, ':name' => $name, ':email' => $email, ':hash' => $hash, ':role' => $role, ':id' => $id]);
        }
        // Jika password kosong, jangan update password
        $stmt = $pdo->prepare('UPDATE users SET username=:username,name=:name,email=:email,role=:role WHERE id=:id');
        return $stmt->execute([':username' => $username, ':name' => $name, ':email' => $email, ':role' => $role, ':id' => $id]);
    }

    // Menghapus data user
    public static function delete(int $id): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Persiapkan query delete
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
        // Eksekusi query hapus
        return $stmt->execute([':id' => $id]);
    }
}
