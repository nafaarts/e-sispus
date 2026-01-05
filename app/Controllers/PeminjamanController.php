<?php
namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\Validator;
use Core\Session;
use Core\Middleware;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Siswa;

// Controller untuk mengelola transaksi Peminjaman
class PeminjamanController extends Controller
{
    // Menampilkan daftar riwayat peminjaman
    public function index()
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_peminjaman');
        
        // Ambil parameter start dan end dari URL
        $start = $_GET['start'] ?? null;
        $end = $_GET['end'] ?? null;
        
        // Jika ada parameter start dan end, filter data peminjaman
        if (isset($start) && isset($end)) {
            $peminjamans = Peminjaman::whereBetweenTanggal($start, $end);
        } else {
            // Ambil semua data peminjaman
            $peminjamans = Peminjaman::all();
        }

        $this->view('peminjaman/index', [
            'peminjamans' => $peminjamans, 
            'start' => $start, 
            'end' => $end
        ]);
    }

    // Menampilkan form transaksi peminjaman baru
    public function create()
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_peminjaman');
        // Ambil data buku dan siswa untuk pilihan di form
        $bukus = Buku::all();
        $siswas = Siswa::all();
        $this->view('peminjaman/create', [
            'bukus' => $bukus,
            'siswas' => $siswas
        ]);
    }

    // Memproses penyimpanan transaksi peminjaman
    public function store()
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_peminjaman');
        // Ambil input
        $data = Request::all();
        // Validasi input
        $validator = new Validator($data);
        $validator->required('nis')
                  ->required('tanggal_pinjam')
                  ->required('tanggal_kembali');

        // Cek apakah ada buku yang dipilih
        if (!isset($data['buku']) || !is_array($data['buku']) || empty($data['buku'])) {
            Session::setFlash('error', 'Pilih minimal satu buku');
            Session::setFlash('old', $data);
            $this->redirect('/index.php?url=peminjaman/create');
            return;
        }

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $data);
            $this->redirect('/index.php?url=peminjaman/create');
            return;
        }

        try {
            // Simpan transaksi peminjaman beserta detail buku
            Peminjaman::create(
                (int)Session::get('user_id'),
                $data['nis'],
                $data['tanggal_pinjam'],
                $data['tanggal_kembali'],
                $data['buku']
            );
            Session::setFlash('success', 'Peminjaman berhasil dicatat');
            $this->redirect('/index.php?url=peminjaman/index');
        } catch (\Exception $e) {
            // Tangkap error jika ada (misal stok habis)
            Session::setFlash('error', 'Gagal mencatat peminjaman: ' . $e->getMessage());
            $this->redirect('/index.php?url=peminjaman/create');
        }
    }

    // Menampilkan detail peminjaman
    public function show(int $id)
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_peminjaman');
        // Cari data peminjaman
        $peminjaman = Peminjaman::find($id);
        if (!$peminjaman) {
            Session::setFlash('error', 'Peminjaman tidak ditemukan');
            $this->redirect('/index.php?url=peminjaman/index');
            return;
        }
        $this->view('peminjaman/show', ['peminjaman' => $peminjaman]);
    }

    // Memproses pengembalian buku
    public function return(int $id)
    {
        Middleware::ensureAuthenticated();
        Middleware::ensureCan('manage_peminjaman');
        // Panggil fungsi returnBooks di model untuk update status dan stok
        if (Peminjaman::returnBooks($id)) {
            Session::setFlash('success', 'Buku berhasil dikembalikan');
        } else {
            Session::setFlash('error', 'Gagal memproses pengembalian');
        }
        $this->redirect('/index.php?url=peminjaman/index');
    }
}
