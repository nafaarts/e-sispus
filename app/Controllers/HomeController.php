<?php
namespace App\Controllers;

use Core\Controller;
use Core\Middleware;
use Core\Database;
use Core\Auth;
use App\Models\Peminjaman;

// Controller untuk halaman utama (Dashboard)
class HomeController extends Controller
{
    // Menampilkan halaman dashboard
    public function index(): void
    {
        // Pastikan user sudah login
        Middleware::ensureAuthenticated();

        // Ambil data user yang sedang login
        $user = Auth::user();
        $role = $user['role'] ?? 'OPERATOR';
        $stats = [];

        // Jika user adalah ADMIN, hitung statistik
        if ($role === 'ADMIN') {
            $pdo = Database::getInstance()->pdo();
            // Hitung total user, buku, dan siswa
            $users = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
            $books = (int)$pdo->query('SELECT COUNT(*) FROM buku')->fetchColumn();
            $students = (int)$pdo->query('SELECT COUNT(*) FROM siswa')->fetchColumn();
            
            // Simpan statistik ke array
            $stats = [
                'users' => $users,
                'books' => $books,
                'students' => $students
            ];
        }

        // Ambil data peminjaman terbaru untuk ditampilkan (baik Admin maupun Operator)
        $latestLoans = Peminjaman::latest(10);

        // Render view dashboard dengan data statistik dan peminjaman terbaru
        $this->view('home/index', [
            'stats' => $stats,
            'latestLoans' => $latestLoans,
            'role' => $role
        ]);
    }
}
