<?php
namespace App\Models;

use Core\Database;

// Model untuk mengelola data Peminjaman
class Peminjaman
{
    // Mengambil data peminjaman terbaru dengan limit tertentu
    public static function latest(int $limit = 10): array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Query untuk mengambil data peminjaman dengan join ke siswa dan users
        $sql = '
            SELECT p.*, s.nama_siswa, u.name as petugas
            FROM peminjaman p
            JOIN siswa s ON p.nis = s.nis
            JOIN users u ON p.id_user = u.id
            ORDER BY p.created_at DESC
            LIMIT :limit
        ';
        // Persiapkan query
        $stmt = $pdo->prepare($sql);
        // Bind parameter limit
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        // Eksekusi query
        $stmt->execute();
        // Kembalikan hasil sebagai array
        return $stmt->fetchAll();
    }

    // Mengambil semua data peminjaman
    public static function all(): array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Query untuk mengambil semua data peminjaman dengan join ke siswa dan users
        $sql = '
            SELECT p.*, s.nama_siswa, u.name as petugas
            FROM peminjaman p
            JOIN siswa s ON p.nis = s.nis
            JOIN users u ON p.id_user = u.id
            ORDER BY p.created_at DESC
        ';
        // Eksekusi query
        $stmt = $pdo->query($sql);
        // Kembalikan hasil sebagai array
        return $stmt->fetchAll();
    }

    // Mengambil data peminjam berdasarkan tanggal
    public static function whereBetweenTanggal($start, $end): array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Query untuk mengambil data peminjaman dengan join ke siswa dan users
        $sql = '
            SELECT p.*, s.nama_siswa, u.name as petugas
            FROM peminjaman p
            JOIN siswa s ON p.nis = s.nis
            JOIN users u ON p.id_user = u.id
            WHERE p.tanggal_pinjam BETWEEN :start AND :end
            ORDER BY p.created_at DESC
        ';
        // Persiapkan query
        $stmt = $pdo->prepare($sql);
        // Bind parameter start dan end
        $stmt->bindValue(':start', $start, \PDO::PARAM_STR);
        $stmt->bindValue(':end', $end, \PDO::PARAM_STR);
        // Eksekusi query
        $stmt->execute();
        // Kembalikan hasil sebagai array
        return $stmt->fetchAll();
    }

    // Mencari peminjaman berdasarkan ID
    public static function find(int $id): ?array
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Query untuk mengambil detail peminjaman beserta data siswa dan kelas
        $stmt = $pdo->prepare('
            SELECT p.*, s.nama_siswa, s.id_kelas, k.nama_kelas, k.tingkat, u.name AS petugas
            FROM peminjaman p
            JOIN siswa s ON p.nis = s.nis
            LEFT JOIN kelas k ON s.id_kelas = k.id_kelas
            JOIN users u ON p.id_user = u.id
            WHERE p.id_peminjaman = :id
        ');
        // Eksekusi query dengan parameter ID
        $stmt->execute([':id' => $id]);
        // Ambil satu baris hasil
        $row = $stmt->fetch();
        
        // Jika data ditemukan
        if ($row) {
            // Ambil detail buku yang dipinjam
            $stmtDetails = $pdo->prepare('
                SELECT d.*, b.judul_buku 
                FROM detail_peminjaman d
                JOIN buku b ON d.kode_buku = b.kode_buku
                WHERE d.id_peminjaman = :id
            ');
            $stmtDetails->execute([':id' => $id]);
            // Masukkan detail buku ke array hasil
            $row['details'] = $stmtDetails->fetchAll();
        }
        
        // Kembalikan hasil atau null
        return $row ?: null;
    }

    // Membuat transaksi peminjaman baru
    public static function create(int $id_user, string $nis, string $tanggal_pinjam, string $tanggal_kembali, array $buku_codes): int
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Mulai transaksi database
        $pdo->beginTransaction();

        try {
            // Insert data peminjaman utama
            $stmt = $pdo->prepare('INSERT INTO peminjaman (id_user, nis, tanggal_pinjam, tanggal_kembali, status) VALUES (:user, :nis, :tgl_pinjam, :tgl_kembali, "pinjam")');
            $stmt->execute([
                ':user' => $id_user,
                ':nis' => $nis,
                ':tgl_pinjam' => $tanggal_pinjam,
                ':tgl_kembali' => $tanggal_kembali
            ]);
            // Dapatkan ID peminjaman yang baru dibuat
            $id_peminjaman = (int)$pdo->lastInsertId();

            // Persiapkan query untuk detail peminjaman
            $stmtDetail = $pdo->prepare('INSERT INTO detail_peminjaman (id_peminjaman, kode_buku) VALUES (:id_peminjaman, :kode_buku)');
            
            // Loop untuk setiap buku yang dipinjam
            foreach ($buku_codes as $kode) {
                // Insert detail peminjaman
                $stmtDetail->execute([
                    ':id_peminjaman' => $id_peminjaman,
                    ':kode_buku' => $kode
                ]);
                // Kurangi stok buku
                Buku::decrementStock($kode);
            }

            // Commit transaksi jika semua berhasil
            $pdo->commit();
            return $id_peminjaman;
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            $pdo->rollBack();
            throw $e;
        }
    }

    // Mengembalikan buku (proses pengembalian)
    public static function returnBooks(int $id_peminjaman): bool
    {
        // Dapatkan koneksi database
        $pdo = Database::getInstance()->pdo();
        // Mulai transaksi database
        $pdo->beginTransaction();

        try {
            // Update status peminjaman menjadi 'kembali'
            $stmt = $pdo->prepare('UPDATE peminjaman SET status = "kembali" WHERE id_peminjaman = :id');
            $stmt->execute([':id' => $id_peminjaman]);

            // Ambil daftar buku yang dipinjam dalam transaksi ini
            $stmtDetails = $pdo->prepare('SELECT kode_buku FROM detail_peminjaman WHERE id_peminjaman = :id');
            $stmtDetails->execute([':id' => $id_peminjaman]);
            $books = $stmtDetails->fetchAll();

            // Loop untuk mengembalikan stok buku
            foreach ($books as $book) {
                Buku::incrementStock($book['kode_buku']);
            }

            // Commit transaksi
            $pdo->commit();
            return true;
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            $pdo->rollBack();
            return false;
        }
    }
}
