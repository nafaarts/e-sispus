<?php
namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\Validator;
use Core\Session;
use Core\Middleware;
use App\Models\Kelas;

// Controller untuk mengelola data Kelas
class KelasController extends Controller
{
    // Menampilkan daftar kelas
    public function index()
    {
        // Cek autentikasi dan otorisasi
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_kelas');
        // Ambil semua data kelas
        $kelases = Kelas::all();
        // Tampilkan view
        $this->view('kelas/index', ['kelases' => $kelases]);
    }

    // Menampilkan form tambah kelas
    public function create()
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_kelas');
        $this->view('kelas/create');
    }

    // Menyimpan data kelas baru
    public function store()
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_kelas');
        // Ambil input
        $data = Request::all();
        // Validasi
        $validator = new Validator($data);
        $validator->required('nama_kelas')->required('tingkat');

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $data);
            $this->redirect('/index.php?url=kelas/create');
            return;
        }

        // Simpan ke database
        Kelas::create($data['nama_kelas'], (int)$data['tingkat']);
        // Pesan sukses
        Session::setFlash('success', 'Kelas berhasil ditambahkan');
        $this->redirect('/index.php?url=kelas/index');
    }

    // Menampilkan form edit kelas
    public function edit(int $id)
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_kelas');
        // Cari kelas berdasarkan ID
        $kelas = Kelas::find($id);
        // Jika tidak ada, redirect error
        if (!$kelas) {
            Session::setFlash('error', 'Kelas tidak ditemukan');
            $this->redirect('/index.php?url=kelas/index');
            return;
        }
        $this->view('kelas/edit', ['kelas' => $kelas]);
    }

    // Update data kelas
    public function update(int $id)
    {
        $data = Request::all();
        $validator = new Validator($data);
        $validator->required('nama_kelas')->required('tingkat');

        if ($validator->fails()) {
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $data);
            $this->redirect("/index.php?url=kelas/edit/$id");
            return;
        }

        Kelas::update($id, $data['nama_kelas'], (int)$data['tingkat']);
        Session::setFlash('success', 'Kelas berhasil diperbarui');
        $this->redirect('/index.php?url=kelas/index');
    }

    // Hapus kelas
    public function delete(int $id)
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_kelas');
        Kelas::delete($id);
        Session::setFlash('success', 'Kelas berhasil dihapus');
        $this->redirect('/index.php?url=kelas/index');
    }
}
