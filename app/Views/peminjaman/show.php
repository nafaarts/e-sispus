<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="mb-0 fw-bold">Detail Peminjaman #<?= $peminjaman['id_peminjaman'] ?></p>
        <div class="d-flex gap-2">
            <!-- Tombol kembali -->
            <a href="/index.php?url=peminjaman/index" class="btn btn-sm btn-secondary">Kembali</a>
            <!-- Tombol konfirmasi pengembalian (jika status masih pinjam) -->
            <?php if (($peminjaman['status'] ?? '') === 'pinjam'): ?>
                <form action="/index.php?url=peminjaman/return/<?= $peminjaman['id_peminjaman'] ?>" method="post" onsubmit="return confirm('Kembalikan semua buku pada peminjaman ini?')">
                    <?= \Core\Csrf::field() ?>
                    <button type="submit" class="btn btn-sm btn-primary">Konfirmasi Pengembalian</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <!-- Informasi Peminjam -->
        <table>
            <tr>
                <th class="py-1" width="150">NIS</th>
                <td class="px-2">:</td>
                <td class="py-1"><?= htmlspecialchars($peminjaman['nis']) ?></td>
            </tr>
            <tr>
                <th class="py-1">Nama Siswa</th>
                <td class="px-2">:</td>
                <td class="py-1"><?= htmlspecialchars($peminjaman['nama_siswa'] ?? '') ?></td>
            </tr>
            <tr>
                <th class="py-1">Kelas</th>
                <td class="px-2">:</td>
                <td class="py-1">
                    <?php if (!empty($peminjaman['nama_kelas'])): ?>
                        <?= htmlspecialchars($peminjaman['nama_kelas']) ?> (Tingkat <?= (int)$peminjaman['tingkat'] ?>)
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
             <tr>
                <th class="py-1">Status</th>
                <td class="px-2">:</td>
                <td class="py-1">
                    <span class="badge bg-<?= $peminjaman['status'] == 'pinjam' ? 'warning' : 'success' ?>">
                        <?= ucfirst($peminjaman['status']) ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th class="py-1">Tanggal Pinjam</th>
                <td class="px-2 py-1">:</td>
                <td class="py-1"><?= $peminjaman['tanggal_pinjam'] ?></td>
            </tr>
            <tr>
                <th class="py-1">Tanggal Kembali</th>
                <td class="px-2 py-1">:</td>
                <td class="py-1"><?= $peminjaman['tanggal_kembali'] ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="mb-0 fw-bold">Daftar Buku yang Dipinjam</p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tabel detail buku yang dipinjam -->
            <table class="table table-striped no-datatable">
                <thead>
                    <tr>
                        <th>Kode Buku</th>
                        <th>Judul Buku</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($peminjaman['details']) && is_array($peminjaman['details'])): ?>
                        <?php foreach ($peminjaman['details'] as $detail): ?>
                        <tr>
                            <td><?= htmlspecialchars($detail['kode_buku']) ?></td>
                            <td><?= htmlspecialchars($detail['judul_buku']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
