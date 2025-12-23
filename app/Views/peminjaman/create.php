<?php use Core\Session; ?>
<?php 
// Ambil error validasi dan data input lama dari session flash
$errors = Session::getFlash('errors', []);
$old = Session::getFlash('old', []);
?>
<!-- Form tambah peminjaman -->
<form action="/index.php?url=peminjaman/store" method="post" class="needs-validation card shadow-lg border-0" novalidate>
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="mb-0 fw-bold">Tambah Peminjaman</p>
    </div>
    <div class="card-body">
        <!-- CSRF Token untuk keamanan form -->
        <?= \Core\Csrf::field() ?>
        
        <!-- Pilihan Siswa -->
        <div class="mb-3">
            <label for="nis" class="form-label">Siswa</label>
            <select class="form-select <?= isset($errors['nis']) ? 'is-invalid' : '' ?>" id="nis" name="nis" required>
                <option value="">Pilih Siswa...</option>
                <?php foreach ($siswas as $siswa): ?>
                    <option value="<?= $siswa['nis'] ?>" <?= (isset($old['nis']) && $old['nis'] == $siswa['nis']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($siswa['nama_siswa']) ?> (<?= htmlspecialchars($siswa['nis']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['nis'])): ?>
                <div class="invalid-feedback"><?= $errors['nis'][0] ?></div>
            <?php endif; ?>
        </div>

        <div class="row">
            <!-- Input Tanggal Pinjam -->
            <div class="col-md-6 mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control <?= isset($errors['tanggal_pinjam']) ? 'is-invalid' : '' ?>" id="tanggal_pinjam" name="tanggal_pinjam" value="<?= $old['tanggal_pinjam'] ?? date('Y-m-d') ?>" required>
            </div>
            <!-- Input Tanggal Kembali -->
            <div class="col-md-6 mb-3">
                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                <input type="date" class="form-control <?= isset($errors['tanggal_kembali']) ? 'is-invalid' : '' ?>" id="tanggal_kembali" name="tanggal_kembali" value="<?= $old['tanggal_kembali'] ?? date('Y-m-d', strtotime('+7 days')) ?>" required>
            </div>
        </div>

        <!-- Pilihan Buku (Multiple) -->
        <div class="mb-3">
            <label class="form-label">Pilih Buku (Tekan Ctrl/Cmd untuk memilih banyak)</label>
            <select class="form-select" name="buku[]" multiple size="10" required>
                <?php foreach ($bukus as $buku): ?>
                    <option value="<?= $buku['kode_buku'] ?>" <?= $buku['stok'] <= 0 ? 'disabled' : '' ?>>
                        <?= htmlspecialchars($buku['judul_buku']) ?> (Stok: <?= $buku['stok'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="form-text">Pastikan stok buku tersedia.</div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <a href="/index.php?url=peminjaman/index" class="btn btn-sm btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-sm btn-primary">Simpan Peminjaman</button>
    </div>
</form>
