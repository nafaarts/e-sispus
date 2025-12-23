<?php use Core\Session; ?>
<!-- Tampilkan pesan sukses jika ada -->
<?php if (Session::hasFlash('success')): ?>
    <div class="alert alert-success"><?= Session::getFlash('success') ?></div>
<?php endif; ?>

<!-- Tampilkan pesan error jika ada -->
<?php if (Session::hasFlash('error')): ?>
    <div class="alert alert-danger"><?= Session::getFlash('error') ?></div>
<?php endif; ?>

<div class="card shadow-lg border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="mb-0 fw-bold">Data Buku</p>
        <!-- Tombol Tambah Buku -->
        <a href="/index.php?url=buku/create" class="btn btn-sm btn-primary">Tambah Buku</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tabel Data Buku -->
            <table class="table table-striped table-hover table-sm mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Stok/Jumlah</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Rak</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bukus as $buku): ?>
                    <tr>
                        <td><?= htmlspecialchars($buku['kode_buku']) ?></td>
                        <td><?= $buku['stok'] ?></td>
                        <td><?= htmlspecialchars($buku['judul_buku']) ?></td>
                        <td><?= htmlspecialchars($buku['pengarang']) ?></td>
                        <td><?= htmlspecialchars($buku['penerbit']) ?></td>
                        <td><?= $buku['tahun_terbit'] ?></td>
                        <td><?= htmlspecialchars($buku['nama_rak']) ?> (<?= htmlspecialchars($buku['lokasi']) ?>)</td>
                        <td class="text-end">
                            <!-- Tombol Edit dan Hapus -->
                            <a href="/index.php?url=buku/edit/<?= $buku['kode_buku'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/index.php?url=buku/delete/<?= $buku['kode_buku'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
