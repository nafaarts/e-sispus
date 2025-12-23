<?php
namespace Core;

// Kelas Helper sederhana untuk melakukan redirect
class Redirect
{
    // Fungsi statis untuk mengarahkan pengguna ke URL tertentu
    public static function to(string $url): void
    {
        // Mengirim header Location
        header('Location: ' . $url);
        // Menghentikan eksekusi script
        exit;
    }
}

