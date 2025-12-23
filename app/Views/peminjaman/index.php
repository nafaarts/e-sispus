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
