<?php
namespace App\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Csrf;

// Controller untuk menangani proses Autentikasi (Login/Logout)
class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login(): void
    {
        // Render view auth/login dengan layout khusus auth
        $this->view('auth/login', ['error' => null, 'csrf' => Csrf::token()], 'layouts/auth');
    }

    // Memproses data login yang dikirim via POST
    public function doLogin(): void
    {
        // Ambil token CSRF dari input
        $token = $_POST['_csrf'] ?? null;
        // Validasi token CSRF
        if (!Csrf::check($token)) {
            http_response_code(400);
            echo 'Invalid CSRF';
            return;
        }
        // Ambil dan bersihkan input email dan password
        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        // Validasi input tidak boleh kosong
        if ($email === '' || $password === '') {
            $this->view('auth/login', ['error' => 'Email dan Password wajib diisi', 'csrf' => Csrf::token()], 'layouts/auth');
            return;
        }
        // Coba proses login menggunakan class Auth
        if (!Auth::login($email, $password)) {
            // Jika gagal, tampilkan pesan error
            $this->view('auth/login', ['error' => 'Kredensial tidak valid', 'csrf' => Csrf::token()], 'layouts/auth');
            return;
        }
        // Jika sukses, redirect ke dashboard/home
        $this->redirect('/index.php?url=home/index');
    }

    // Memproses logout
    public function logout(): void
    {
        // Panggil fungsi logout dari Auth untuk hapus sesi
        Auth::logout();
        // Redirect kembali ke halaman login
        $this->redirect('/index.php?url=auth/login');
    }
}

