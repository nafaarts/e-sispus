<?php
namespace Core;

// Kelas View bertugas untuk merender tampilan (HTML)
class View
{
    // Fungsi untuk merender file view dengan layout
    public static function render(string $view, array $params = [], string $layout = 'layouts/main'): void
    {
        // Path file view konten utama
        $viewFile = __DIR__ . '/../app/Views/' . $view . '.php';
        // Path file layout (kerangka halaman)
        $layoutFile = __DIR__ . '/../app/Views/' . $layout . '.php';

        // Mengekstrak variabel dari array params agar bisa diakses langsung di view
        // EXTR_SKIP: Jangan timpa variabel jika nama sudah ada
        extract($params, EXTR_SKIP);

        // Memulai output buffering
        ob_start();
        // Memuat file view konten
        require $viewFile;
        // Mengambil isi buffer ke variabel $content dan membersihkan buffer
        $content = ob_get_clean();

        // Memuat file layout yang akan menampilkan $content di dalamnya
        require $layoutFile;
    }
}

