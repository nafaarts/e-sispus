<?php
namespace Core;

// Kelas Controller sebagai base class untuk semua controller
class Controller
{
    // Fungsi untuk merender view dengan parameter dan layout tertentu
    protected function view(string $view, array $params = [], string $layout = 'layouts/main'): void
    {
        // Memanggil fungsi render dari class View
        View::render($view, $params, $layout);
    }

    // Fungsi untuk mengarahkan pengguna ke halaman lain (redirect)
    protected function redirect(string $path): void
    {
        // Mengirim header Location untuk redirect
        header('Location: ' . $path);
        // Menghentikan eksekusi script
        exit;
    }
}

