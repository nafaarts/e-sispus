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
        <p class="mb-0 fw-bold">Data Siswa</p>
        <!-- Tombol tambah siswa baru -->
        <a href="/index.php?url=siswa/create" class="btn btn-sm btn-primary">Tambah Siswa</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tabel data siswa -->
            <table class="table table-striped table-hover table-sm mb-0">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>L/P</th>
                        <th>Alamat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop data siswa -->
                    <?php foreach ($siswas as $siswa): ?>
                    <tr>
                        <td><?= htmlspecialchars($siswa['nis']) ?></td>
                        <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                        <td><?= htmlspecialchars($siswa['nama_kelas']) ?></td>
                        <td><?= $siswa['jekel'] ?></td>
                        <td><?= htmlspecialchars($siswa['alamat']) ?></td>
                        <td class="text-end">
                            <!-- Tombol aksi edit dan hapus -->
                            <a href="/index.php?url=siswa/edit/<?= $siswa['nis'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/index.php?url=siswa/delete/<?= $siswa['nis'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
