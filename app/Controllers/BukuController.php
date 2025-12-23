<?php
namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\Validator;
use Core\Session;
use App\Models\Buku;
use App\Models\Rak;
use Core\Middleware;

// Controller untuk mengelola data Buku
class BukuController extends Controller
{
    // Menampilkan daftar semua buku
    public function index()
    {
        // Ambil semua data buku dari model
        $bukus = Buku::all();
        // Tampilkan view index buku
        $this->view('buku/index', ['bukus' => $bukus]);
    }

    // Menampilkan form tambah buku
    public function create()
    {
        // Ambil data rak untuk dropdown lokasi
        $raks = Rak::all();
        // Tampilkan view form create buku
        $this->view('buku/create', ['raks' => $raks]);
    }

    // Menyimpan data buku baru
    public function store()
    {
        // Ambil semua data input
        $data = Request::all();
        // Validasi input
        $validator = new Validator($data);
        $validator->required('kode_buku')
                  ->required('id_rak')
                  ->required('judul_buku')
                  ->required('stok');

        // Jika validasi gagal
        if ($validator->fails()) {
            // Simpan error dan input lama ke session flash
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $data);
            // Redirect kembali ke form create
            $this->redirect('/index.php?url=buku/create');
            return;
        }

        // Simpan data buku baru ke database
        Buku::create(
            $data['kode_buku'],
            (int)$data['id_rak'],
            $data['judul_buku'],
            $data['pengarang'] ?? '',
            $data['penerbit'] ?? '',
            (int)($data['tahun_terbit'] ?? 0),
            (int)$data['stok']
        );
        // Set pesan sukses
        Session::setFlash('success', 'Buku berhasil ditambahkan');
        // Redirect ke daftar buku
        $this->redirect('/index.php?url=buku/index');
    }

    // Menampilkan form edit buku
    public function edit(string $kode)
    {
        // Pastikan user login dan punya akses
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_buku');
        // Cari data buku berdasarkan kode
        $buku = Buku::find($kode);
        // Jika tidak ditemukan, redirect dengan pesan error
        if (!$buku) {
            Session::setFlash('error', 'Buku tidak ditemukan');
            $this->redirect('/index.php?url=buku/index');
            return;
        }
        // Ambil data rak untuk dropdown
        $raks = Rak::all();
        // Tampilkan view edit
        $this->view('buku/edit', ['buku' => $buku, 'raks' => $raks]);
    }

    // Mengupdate data buku yang sudah ada
    public function update(string $kode)
    {
        // Ambil data input
        $data = Request::all();
        // Validasi input
        $validator = new Validator($data);
        $validator->required('id_rak')
                  ->required('judul_buku')
                  ->required('stok');

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $data);
            $this->redirect("/index.php?url=buku/edit/$kode");
            return;
        }

        // Update data buku di database
        Buku::update(
            $kode,
            (int)$data['id_rak'],
            $data['judul_buku'],
            $data['pengarang'] ?? '',
            $data['penerbit'] ?? '',
            (int)($data['tahun_terbit'] ?? 0),
            (int)$data['stok']
        );
        // Set pesan sukses
        Session::setFlash('success', 'Buku berhasil diperbarui');
        $this->redirect('/index.php?url=buku/index');
    }

    // Menghapus data buku
    public function delete(string $kode)
    {
        // Pastikan user login dan punya akses
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_buku');
        // Hapus buku dari database
        Buku::delete($kode);
        // Set pesan sukses
        Session::setFlash('success', 'Buku berhasil dihapus');
        $this->redirect('/index.php?url=buku/index');
    }
}
