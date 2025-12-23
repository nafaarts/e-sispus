<!-- Form tambah pengguna -->
<form method="post" action="/index.php?url=users/store" class="needs-validation card shadow-lg border-0" novalidate>
  <div class="card-header d-flex justify-content-between align-items-center">
    <p class="mb-0 fw-bold">Tambah Pengguna</p>
  </div>
  <div class="card-body">
    <!-- CSRF Token -->
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
    
    <!-- Input Username -->
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input class="form-control" type="text" name="username" value="<?= htmlspecialchars($old['username'] ?? '') ?>" required>
    </div>
    
    <!-- Input Nama -->
    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input class="form-control" type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
    </div>
    
    <!-- Input Email -->
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
    </div>
    
    <!-- Input Password -->
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input class="form-control" type="password" name="password" required>
    </div>
    
    <!-- Pilihan Role -->
    <div class="mb-3">
      <label class="form-label">Role</label>
      <select class="form-select" name="role" required>
        <option value="">Pilih Role</option>
        <option value="ADMIN" <?= (isset($old['role']) && $old['role'] === 'ADMIN') ? 'selected' : '' ?>>ADMIN</option>
        <option value="OPERATOR" <?= (isset($old['role']) && $old['role'] === 'OPERATOR') ? 'selected' : '' ?>>OPERATOR</option>
      </select>
    </div>
  </div>
  <div class="card-footer d-flex justify-content-end gap-2">
    <a class="btn btn-sm btn-secondary" href="/index.php?url=users/index">Kembali</a>
    <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
  </div>
</form>
