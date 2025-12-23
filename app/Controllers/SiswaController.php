<?php
namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\Validator;
use Core\Session;
use Core\Middleware;
use App\Models\Siswa;
use App\Models\Kelas;

// Controller untuk mengelola data Siswa
class SiswaController extends Controller
{
    // Menampilkan daftar siswa
    public function index()
    {
        // Pastikan pengguna sudah login
        Middleware::ensureAuthenticated();
        // Pastikan pengguna memiliki hak akses 'manage_siswa'
        Middleware::ensureCan('manage_siswa');
        // Ambil semua data siswa
        $siswas = Siswa::all();
        // Tampilkan view dengan data siswa
        $this->view('siswa/index', ['siswas' => $siswas]);
    }

    // Menampilkan form tambah siswa
    public function create()
    {
        // Pastikan pengguna sudah login
        Middleware::ensureAuthenticated();
        // Pastikan pengguna memiliki hak akses 'manage_siswa'
        Middleware::ensureCan('manage_siswa');
        // Ambil semua data kelas untuk pilihan
        $kelases = Kelas::all();
        // Tampilkan view form tambah siswa
        $this->view('siswa/create', ['kelases' => $kelases]);
    }

    // Menyimpan data siswa baru
    public function store()
    {
        // Pastikan pengguna sudah login
        Middleware::ensureAuthenticated();
        // Pastikan pengguna memiliki hak akses 'manage_siswa'
        Middleware::ensureCan('manage_siswa');
        // Ambil data input dari request
        $data = Request::all();
        // Validasi input
        $validator = new Validator($data);
        $validator->required('nis')
                  ->required('id_kelas')
                  ->required('nama_siswa')
                  ->required('jekel');

        // Jika validasi gagal
        if ($validator->fails()) {
            // Simpan error ke flash session
            Session::setFlash('errors', $validator->errors());
            // Simpan input lama ke flash session
            Session::setFlash('old', $data);
            // Redirect kembali ke halaman create
            $this->redirect('/index.php?url=siswa/create');
            return;
        }

        // Simpan data siswa ke database
        Siswa::create(
            $data['nis'],
            (int)$data['id_kelas'],
            $data['nama_siswa'],
            $data['jekel'],
            $data['alamat'] ?? ''
        );
        // Set pesan sukses
        Session::setFlash('success', 'Siswa berhasil ditambahkan');
        // Redirect ke halaman index siswa
        $this->redirect('/index.php?url=siswa/index');
    }

    // Menampilkan form edit siswa
    public function edit(string $nis)
    {
        // Pastikan pengguna sudah login
        Middleware::ensureAuthenticated();
        // Pastikan pengguna memiliki hak akses 'manage_siswa'
        Middleware::ensureCan('manage_siswa');
        // Cari siswa berdasarkan NIS
        $siswa = Siswa::find($nis);
        // Jika siswa tidak ditemukan
        if (!$siswa) {
            Session::setFlash('error', 'Siswa tidak ditemukan');
            $this->redirect('/index.php?url=siswa/index');
            return;
        }
        // Ambil semua data kelas
        $kelases = Kelas::all();
        // Tampilkan view edit dengan data siswa dan kelas
        $this->view('siswa/edit', ['siswa' => $siswa, 'kelases' => $kelases]);
    }

    // Memperbarui data siswa
    public function update(string $nis)
    {
        // Pastikan pengguna sudah login
        Middleware::ensureAuthenticated();
        // Pastikan pengguna memiliki hak akses 'manage_siswa'
        Middleware::ensureCan('manage_siswa');
        // Ambil data input
        $data = Request::all();
        // Validasi input
        $validator = new Validator($data);
        $validator->required('id_kelas')
                  ->required('nama_siswa')
                  ->required('jekel');

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $data);
            $this->redirect("/index.php?url=siswa/edit/$nis");
            return;
        }

        // Update data siswa di database
        Siswa::update(
            $nis,
            (int)$data['id_kelas'],
            $data['nama_siswa'],
            $data['jekel'],
            $data['alamat'] ?? ''
        );
        // Set pesan sukses
        Session::setFlash('success', 'Siswa berhasil diperbarui');
        // Redirect ke halaman index siswa
        $this->redirect('/index.php?url=siswa/index');
    }

    // Menghapus data siswa
    public function delete(string $nis)
    {
        // Pastikan pengguna sudah login
        Middleware::ensureAuthenticated();
        // Pastikan pengguna memiliki hak akses 'manage_siswa'
        Middleware::ensureCan('manage_siswa');
        // Hapus siswa dari database
        Siswa::delete($nis);
        // Set pesan sukses
        Session::setFlash('success', 'Siswa berhasil dihapus');
        // Redirect ke halaman index siswa
        $this->redirect('/index.php?url=siswa/index');
    }
}
