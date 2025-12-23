<?php use Core\Session; ?>
<?php 
// Ambil error validasi dan data input lama dari session flash
$errors = Session::getFlash('errors', []);
$old = Session::getFlash('old', []);
?>
<!-- Form tambah rak -->
<form action="/index.php?url=rak/store" method="post" class="needs-validation card shadow-lg border-0" novalidate>
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="mb-0 fw-bold">Tambah Rak</p>
    </div>
    <div class="card-body">
        <!-- CSRF Token untuk keamanan form -->
        <?= \Core\Csrf::field() ?>
        
        <!-- Input Nama Rak -->
        <div class="mb-3">
            <label for="nama_rak" class="form-label">Nama Rak</label>
            <input type="text" class="form-control <?= isset($errors['nama_rak']) ? 'is-invalid' : '' ?>" id="nama_rak" name="nama_rak" value="<?= $old['nama_rak'] ?? '' ?>" required>
            <?php if (isset($errors['nama_rak'])): ?>
                <div class="invalid-feedback"><?= $errors['nama_rak'][0] ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Input Lokasi Rak -->
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" class="form-control <?= isset($errors['lokasi']) ? 'is-invalid' : '' ?>" id="lokasi" name="lokasi" value="<?= $old['lokasi'] ?? '' ?>" required>
            <?php if (isset($errors['lokasi'])): ?>
                <div class="invalid-feedback"><?= $errors['lokasi'][0] ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <a href="/index.php?url=rak/index" class="btn btn-sm btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
    </div>
</form>
