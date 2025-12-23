<?php use Core\Session; ?>
<?php 
// Ambil error validasi dan data input lama (atau data saat ini) dari session flash
$errors = Session::getFlash('errors', []);
$old = Session::getFlash('old', $siswa);
?>
<!-- Form edit siswa -->
<form action="/index.php?url=siswa/update/<?= $siswa['nis'] ?>" method="post" class="needs-validation card shadow-lg border-0" novalidate>
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="mb-0 fw-bold">Edit Siswa</p>
    </div>
    <div class="card-body">
        <!-- CSRF Token untuk keamanan form -->
        <?= \Core\Csrf::field() ?>
        
        <!-- Input NIS (disabled karena primary key) -->
        <div class="mb-3">
            <label class="form-label">NIS</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($siswa['nis']) ?>" disabled>
        </div>

        <!-- Pilihan Kelas -->
        <div class="mb-3">
            <label for="id_kelas" class="form-label">Kelas</label>
            <select class="form-select <?= isset($errors['id_kelas']) ? 'is-invalid' : '' ?>" id="id_kelas" name="id_kelas" required>
                <option value="">Pilih Kelas...</option>
                <?php foreach ($kelases as $kelas): ?>
                    <option value="<?= $kelas['id_kelas'] ?>" <?= ($old['id_kelas'] ?? $siswa['id_kelas']) == $kelas['id_kelas'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kelas['nama_kelas']) ?> (Tingkat <?= $kelas['tingkat'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!-- Input Nama Siswa -->
        <div class="mb-3">
            <label for="nama_siswa" class="form-label">Nama Siswa</label>
            <input type="text" class="form-control <?= isset($errors['nama_siswa']) ? 'is-invalid' : '' ?>" id="nama_siswa" name="nama_siswa" value="<?= $old['nama_siswa'] ?? $siswa['nama_siswa'] ?>" required>
        </div>

        <!-- Pilihan Jenis Kelamin -->
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jekel" id="jekelL" value="L" <?= ($old['jekel'] ?? $siswa['jekel']) == 'L' ? 'checked' : '' ?> required>
                <label class="form-check-label" for="jekelL">Laki-laki</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jekel" id="jekelP" value="P" <?= ($old['jekel'] ?? $siswa['jekel']) == 'P' ? 'checked' : '' ?> required>
                <label class="form-check-label" for="jekelP">Perempuan</label>
            </div>
        </div>

        <!-- Input Alamat -->
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $old['alamat'] ?? $siswa['alamat'] ?></textarea>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <a href="/index.php?url=siswa/index" class="btn btn-sm btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-sm btn-primary">Update</button>
    </div>
</form>
