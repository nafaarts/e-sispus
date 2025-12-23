<?php
// Load autoloader untuk memuat class secara otomatis
require __DIR__ . '/../core/Autoloader.php';

use Core\Session;
use Core\Env;

// Load environment variables dari file .env
Env::load(__DIR__ . '/../.env');

// Memulai session PHP
Session::start();

// Parsing URL untuk routing sederhana
// Ambil parameter 'url' dari query string, default string kosong
$url = $_GET['url'] ?? '';
$url = trim($url, '/');

// Pecah URL menjadi segmen (controller/method/params)
// Default controller: 'home', default method: 'index'
$segments = $url !== '' ? explode('/', $url) : ['home', 'index'];

// Ambil nama controller dan bersihkan karakter non-alphanumeric
$controllerName = preg_replace('/[^a-zA-Z0-9_]/', '', strtolower($segments[0] ?? 'home'));
// Ambil nama method dan bersihkan karakter non-alphanumeric
$methodName = preg_replace('/[^a-zA-Z0-9_]/', '', strtolower($segments[1] ?? 'index'));
// Ambil parameter sisa sebagai argumen untuk method
$params = array_slice($segments, 2);

// Bentuk nama class controller lengkap dengan namespace
$controllerClass = 'App\\Controllers\\' . ucfirst($controllerName) . 'Controller';

// Cek apakah class controller ada
if (!class_exists($controllerClass)) {
    http_response_code(404);
    echo 'Controller tidak ditemukan';
    exit;
}

// Instansiasi controller
$controller = new $controllerClass();

// Cek apakah method ada di dalam controller
if (!method_exists($controller, $methodName)) {
    http_response_code(404);
    echo 'Method tidak ditemukan';
    exit;
}

// Panggil method controller dengan parameter yang diberikan
call_user_func_array([$controller, $methodName], $params);

