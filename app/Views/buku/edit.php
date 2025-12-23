<?php use Core\Session; ?>
<?php 
// Ambil data flash session untuk error dan input lama
$errors = Session::getFlash('errors', []);
$old = Session::getFlash('old', $buku);
?>
<!-- Form Edit Buku -->
<form action="/index.php?url=buku/update/<?= $buku['kode_buku'] ?>" method="post" class="needs-validation card shadow-lg border-0" novalidate>
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="mb-0 fw-bold">Edit Buku</p>
    </div>
    <div class="card-body">
        <!-- Token CSRF -->
        <?= \Core\Csrf::field() ?>
        
        <!-- Input Kode Buku (Readonly) -->
        <div class="mb-3">
            <label class="form-label">Kode Buku</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($buku['kode_buku']) ?>" disabled>
        </div>

        <!-- Pilihan Rak -->
        <div class="mb-3">
            <label for="id_rak" class="form-label">Rak</label>
            <select class="form-select <?= isset($errors['id_rak']) ? 'is-invalid' : '' ?>" id="id_rak" name="id_rak" required>
                <option value="">Pilih Rak...</option>
                <?php foreach ($raks as $rak): ?>
                    <option value="<?= $rak['id_rak'] ?>" <?= ($old['id_rak'] ?? $buku['id_rak']) == $rak['id_rak'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($rak['nama_rak']) ?> (<?= htmlspecialchars($rak['lokasi']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!-- Input Judul Buku -->
        <div class="mb-3">
            <label for="judul_buku" class="form-label">Judul Buku</label>
            <input type="text" class="form-control <?= isset($errors['judul_buku']) ? 'is-invalid' : '' ?>" id="judul_buku" name="judul_buku" value="<?= $old['judul_buku'] ?? $buku['judul_buku'] ?>" required>
        </div>

        <div class="row">
            <!-- Input Pengarang -->
            <div class="col-md-6 mb-3">
                <label for="pengarang" class="form-label">Pengarang</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?= $old['pengarang'] ?? $buku['pengarang'] ?>">
            </div>
            <!-- Input Penerbit -->
            <div class="col-md-6 mb-3">
                <label for="penerbit" class="form-label">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= $old['penerbit'] ?? $buku['penerbit'] ?>">
            </div>
        </div>

        <div class="row">
            <!-- Input Tahun Terbit -->
            <div class="col-md-6 mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?= $old['tahun_terbit'] ?? $buku['tahun_terbit'] ?>">
            </div>
            <!-- Input Stok -->
            <div class="col-md-6 mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control <?= isset($errors['stok']) ? 'is-invalid' : '' ?>" id="stok" name="stok" value="<?= $old['stok'] ?? $buku['stok'] ?>" required>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <a href="/index.php?url=buku/index" class="btn btn-sm btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-sm btn-primary">Update</button>
    </div>
</form>
