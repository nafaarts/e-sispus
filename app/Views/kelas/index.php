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
        <p class="mb-0 fw-bold">Data Kelas</p>
        <!-- Tombol tambah kelas baru -->
        <a href="/index.php?url=kelas/create" class="btn btn-sm btn-primary">Tambah Kelas</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tabel data kelas -->
            <table class="table table-striped table-hover table-sm mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kelas</th>
                        <th>Tingkat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop data kelas -->
                    <?php foreach ($kelases as $kelas): ?>
                    <tr>
                        <td><?= $kelas['id_kelas'] ?></td>
                        <td><?= htmlspecialchars($kelas['nama_kelas']) ?></td>
                        <td><?= $kelas['tingkat'] ?></td>
                        <td class="text-end">
                            <!-- Tombol aksi edit dan hapus -->
                            <a href="/index.php?url=kelas/edit/<?= $kelas['id_kelas'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/index.php?url=kelas/delete/<?= $kelas['id_kelas'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
