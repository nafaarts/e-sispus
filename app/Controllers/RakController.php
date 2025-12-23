<?php
namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\Validator;
use Core\Session;
use Core\Middleware;
use App\Models\Rak;

// Controller untuk mengelola data Rak Buku
class RakController extends Controller
{
    // Menampilkan daftar rak
    public function index()
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_rak');
        // Ambil semua data rak
        $raks = Rak::all();
        // Tampilkan view
        $this->view('rak/index', ['raks' => $raks]);
    }

    // Menampilkan form tambah rak
    public function create()
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_rak');
        $this->view('rak/create');
    }

    // Menyimpan data rak baru
    public function store()
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_rak');
        // Ambil input
        $data = Request::all();
        // Validasi input
        $validator = new Validator($data);
        $validator->required('nama_rak')->required('lokasi');

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $data);
            $this->redirect('/index.php?url=rak/create');
            return;
        }

        // Simpan ke database
        Rak::create($data['nama_rak'], $data['lokasi']);
        Session::setFlash('success', 'Rak berhasil ditambahkan');
        $this->redirect('/index.php?url=rak/index');
    }

    // Menampilkan form edit rak
    public function edit(int $id)
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_rak');
        // Cari rak berdasarkan ID
        $rak = Rak::find($id);
        if (!$rak) {
            Session::setFlash('error', 'Rak tidak ditemukan');
            $this->redirect('/index.php?url=rak/index');
            return;
        }
        $this->view('rak/edit', ['rak' => $rak]);
    }

    // Update data rak
    public function update(int $id)
    {
        $data = Request::all();
        $validator = new Validator($data);
        $validator->required('nama_rak')->required('lokasi');

        if ($validator->fails()) {
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $data);
            $this->redirect("/index.php?url=rak/edit/$id");
            return;
        }

        Rak::update($id, $data['nama_rak'], $data['lokasi']);
        Session::setFlash('success', 'Rak berhasil diperbarui');
        $this->redirect('/index.php?url=rak/index');
    }

    // Hapus data rak
    public function delete(int $id)
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_rak');
        Rak::delete($id);
        Session::setFlash('success', 'Rak berhasil dihapus');
        $this->redirect('/index.php?url=rak/index');
    }
}
