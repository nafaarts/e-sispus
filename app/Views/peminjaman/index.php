<?php use Core\Session; ?>

<!-- Menampilkan pesan flash sukses jika ada -->
<?php if (Session::hasFlash('success')): ?>
    <div class="alert alert-success"><?= Session::getFlash('success') ?></div>
<?php endif; ?>

<!-- Menampilkan pesan flash error jika ada -->
<?php if (Session::hasFlash('error')): ?>
    <div class="alert alert-danger"><?= Session::getFlash('error') ?></div>
<?php endif; ?>

<div class="card shadow-lg border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="mb-0 fw-bold">Data Peminjaman</p>
        <!-- Tombol tambah peminjaman baru -->
        <a href="/index.php?url=peminjaman/create" class="btn btn-sm btn-primary">Tambah Peminjaman</a>
    </div>
    <div class="card-body">
        <!-- filter -->
        <div class="mb-3" style="width: 500px;">
            <label for="start" class="mb-2">Filter Berdasarkan Tanggal Pinjam</label>
            <form id="filterForm" action="/index.php?url=peminjaman/index" method="get"  class="d-flex align-items-center gap-2">
                <input type="date" name="start" class="form-control form-control-sm" placeholder="Dari Tanggal" value="<?= $start ?>">
                <input type="date" name="end" class="form-control form-control-sm" placeholder="Sampai Tanggal" value="<?= $end ?>">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
            </form>

            <script>
                // Validasi form filter
                document.getElementById('filterForm').addEventListener('submit', function(e) {
                    e.preventDefault(); // Hentikan submit
                    
                    // Ambil nilai input
                    const start = this.start.value;
                    const end = this.end.value;
                    
                    // Cek apakah kedua tanggal diisi
                    if (!start || !end) {
                        alert('Mohon isi kedua tanggal filter!');
                        return
                    }

                    // Cek apakah tanggal pinjam lebih besar dari tanggal kembal
                    if (start > end) {
                        alert('Tanggal pinjam tidak boleh lebih besar dari tanggal kembal!');
                        return
                    }
                    
                    window.location.href = '/index.php?url=peminjaman/index&start=' + start + '&end=' + end;
                });
            </script>
        </div>

        <div class="table-responsive">
            <!-- Tabel data peminjaman -->
            <table class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Siswa</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Petugas</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop data peminjaman -->
                    <?php foreach ($peminjamans as $pinjam): ?>
                    <tr>
                        <td><?= $pinjam['id_peminjaman'] ?></td>
                        <td><?= htmlspecialchars($pinjam['nama_siswa']) ?> (<?= htmlspecialchars($pinjam['nis']) ?>)</td>
                        <td><?= $pinjam['tanggal_pinjam'] ?></td>
                        <td><?= $pinjam['tanggal_kembali'] ?></td>
                        <td>
                            <!-- Badge status peminjaman -->
                            <span class="badge bg-<?= $pinjam['status'] == 'pinjam' ? 'warning' : 'success' ?>">
                                <?= ucfirst($pinjam['status']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($pinjam['petugas']) ?></td>
                        <td class="text-end">
                            <!-- Tombol detail peminjaman -->
                            <a href="/index.php?url=peminjaman/show/<?= $pinjam['id_peminjaman'] ?>" class="btn btn-sm btn-success">Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
