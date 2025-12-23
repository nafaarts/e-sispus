<?php use Core\Session; ?>
<?php 
// Ambil error validasi dan data input lama dari session flash
$errors = Session::getFlash('errors', []);
$old = Session::getFlash('old', []);
?>
<!-- Form tambah siswa -->
<form action="/index.php?url=siswa/store" method="post" class="needs-validation card shadow-lg border-0" novalidate>
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="mb-0 fw-bold">Tambah Siswa</p>
    </div>
    <div class="card-body">
        <!-- CSRF Token untuk keamanan form -->
        <?= \Core\Csrf::field() ?>
        <div class="row">
            <!-- Input NIS -->
            <div class="col-md-6 mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" class="form-control <?= isset($errors['nis']) ? 'is-invalid' : '' ?>" id="nis" name="nis" value="<?= $old['nis'] ?? '' ?>" required>
                <?php if (isset($errors['nis'])): ?>
                    <div class="invalid-feedback"><?= $errors['nis'][0] ?></div>
                <?php endif; ?>
            </div>
            <!-- Pilihan Kelas -->
            <div class="col-md-6 mb-3">
                <label for="id_kelas" class="form-label">Kelas</label>
                <select class="form-select <?= isset($errors['id_kelas']) ? 'is-invalid' : '' ?>" id="id_kelas" name="id_kelas" required>
                    <option value="">Pilih Kelas...</option>
                    <?php foreach ($kelases as $kelas): ?>
                        <option value="<?= $kelas['id_kelas'] ?>" <?= (isset($old['id_kelas']) && $old['id_kelas'] == $kelas['id_kelas']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kelas['nama_kelas']) ?> (Tingkat <?= $kelas['tingkat'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <!-- Input Nama Siswa -->
        <div class="mb-3">
            <label for="nama_siswa" class="form-label">Nama Siswa</label>
            <input type="text" class="form-control <?= isset($errors['nama_siswa']) ? 'is-invalid' : '' ?>" id="nama_siswa" name="nama_siswa" value="<?= $old['nama_siswa'] ?? '' ?>" required>
        </div>

        <!-- Pilihan Jenis Kelamin -->
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jekel" id="jekelL" value="L" <?= (isset($old['jekel']) && $old['jekel'] == 'L') ? 'checked' : '' ?> required>
                <label class="form-check-label" for="jekelL">Laki-laki</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jekel" id="jekelP" value="P" <?= (isset($old['jekel']) && $old['jekel'] == 'P') ? 'checked' : '' ?> required>
                <label class="form-check-label" for="jekelP">Perempuan</label>
            </div>
        </div>

        <!-- Input Alamat -->
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $old['alamat'] ?? '' ?></textarea>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <a href="/index.php?url=siswa/index" class="btn btn-sm btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
    </div>
</form>
