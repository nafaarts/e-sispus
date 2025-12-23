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
        <p class="mb-0 fw-bold">Data Rak</p>
        <!-- Tombol tambah rak baru -->
        <a href="/index.php?url=rak/create" class="btn btn-sm btn-primary">Tambah Rak</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tabel data rak -->
            <table class="table table-striped table-hover table-sm mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Rak</th>
                        <th>Lokasi</th>
                        <th>Jumlah Buku</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop data rak -->
                    <?php foreach ($raks as $rak): ?>
                    <tr>
                        <td><?= $rak['id_rak'] ?></td>
                        <td><?= htmlspecialchars($rak['nama_rak']) ?></td>
                        <td><?= htmlspecialchars($rak['lokasi']) ?></td>
                        <td><?= (int)($rak['jumlah_buku'] ?? 0) ?></td>
                        <td class="text-end">
                            <!-- Tombol aksi edit dan hapus -->
                            <a href="/index.php?url=rak/edit/<?= $rak['id_rak'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/index.php?url=rak/delete/<?= $rak['id_rak'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
