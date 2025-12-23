<?php use Core\Session; ?>
<?php 
// Ambil error validasi dan data input lama dari session flash
$errors = Session::getFlash('errors', []);
$old = Session::getFlash('old', []);
?>
<!-- Form tambah kelas -->
<form action="/index.php?url=kelas/store" method="post" class="needs-validation card shadow-lg border-0" novalidate>
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="mb-0 fw-bold">Tambah Kelas</p>
    </div>
    <div class="card-body">
        <!-- CSRF Token untuk keamanan form -->
        <?= \Core\Csrf::field() ?>
        
        <!-- Input Nama Kelas -->
        <div class="mb-3">
            <label for="nama_kelas" class="form-label">Nama Kelas</label>
            <input type="text" class="form-control <?= isset($errors['nama_kelas']) ? 'is-invalid' : '' ?>" id="nama_kelas" name="nama_kelas" value="<?= $old['nama_kelas'] ?? '' ?>" required>
            <?php if (isset($errors['nama_kelas'])): ?>
                <div class="invalid-feedback"><?= $errors['nama_kelas'][0] ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Input Tingkat Kelas -->
        <div class="mb-3">
            <label for="tingkat" class="form-label">Tingkat</label>
            <input type="number" class="form-control <?= isset($errors['tingkat']) ? 'is-invalid' : '' ?>" id="tingkat" name="tingkat" value="<?= $old['tingkat'] ?? '' ?>" required>
            <?php if (isset($errors['tingkat'])): ?>
                <div class="invalid-feedback"><?= $errors['tingkat'][0] ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <a href="/index.php?url=kelas/index" class="btn btn-sm btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
    </div>
</form>
