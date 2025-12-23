<!-- Dashboard hanya untuk Admin -->
<?php if (($role ?? 'OPERATOR') === 'ADMIN'): ?>
<div class="row g-3 mb-4">
  <!-- Card Statistik Pengguna -->
  <div class="col-md-4">
    <div class="card shadow-lg border-0 text-white bg-success">
      <div class="card-body">
        <h6 class="card-title">Pengguna</h6>
        <div class="display-6"><?= (int)$stats['users'] ?></div>
      </div>
    </div>
  </div>
  <!-- Card Statistik Buku -->
  <div class="col-md-4">
    <div class="card shadow-lg border-0 text-white bg-success">
      <div class="card-body">
        <h6 class="card-title">Buku</h6>
        <div class="display-6"><?= (int)$stats['books'] ?></div>
      </div>
    </div>
  </div>
  <!-- Card Statistik Siswa -->
  <div class="col-md-4">
    <div class="card shadow-lg border-0 text-white bg-success">
      <div class="card-body">
        <h6 class="card-title">Siswa</h6>
        <div class="display-6"><?= (int)$stats['students'] ?></div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Tabel Peminjaman Terakhir -->
<div class="card shadow-lg border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <small class="mb-0">Peminjaman Terakhir</small>
        <!-- Tombol lihat semua data peminjaman -->
        <a href="/index.php?url=peminjaman/index" class="btn btn-sm btn-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tabel data peminjaman -->
            <table class="table table-striped table-hover no-datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Siswa</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($latestLoans)): ?>
                    <!-- Pesan jika belum ada data -->
                    <tr><td colspan="5" class="text-center">Belum ada data peminjaman</td></tr>
                <?php else: ?>
                    <!-- Loop data peminjaman terakhir -->
                    <?php foreach ($latestLoans as $loan): ?>
                    <tr>
                        <td><?= (int)$loan['id_peminjaman'] ?></td>
                        <td><?= htmlspecialchars($loan['nama_siswa']) ?></td>
                        <td><?= htmlspecialchars($loan['tanggal_pinjam']) ?></td>
                        <td>
                            <!-- Badge status peminjaman -->
                            <?php if ($loan['status'] === 'pinjam'): ?>
                                <span class="badge bg-warning">Dipinjam</span>
                            <?php else: ?>
                                <span class="badge bg-success">Kembali</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($loan['petugas']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
