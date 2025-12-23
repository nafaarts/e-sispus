<!-- Form edit pengguna -->
<form method="post" action="/index.php?url=users/update/<?= (int)$user['id'] ?>" class="needs-validation card shadow-lg border-0" novalidate>
  <div class="card-header d-flex justify-content-between align-items-center">
    <p class="mb-0 fw-bold">Edit Pengguna</p>
  </div>
  <div class="card-body">
    <!-- CSRF Token -->
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
    
    <!-- Input Username -->
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input class="form-control" type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
    </div>
    
    <!-- Input Nama -->
    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input class="form-control" type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>
    
    <!-- Input Email -->
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    
    <!-- Input Password (opsional) -->
    <div class="mb-3">
      <label class="form-label">Password (opsional)</label>
      <input class="form-control" type="password" name="password">
    </div>
    
    <!-- Pilihan Role -->
    <div class="mb-3">
      <label class="form-label">Role</label>
      <select class="form-select" name="role" required>
        <option value="ADMIN" <?= ($user['role'] ?? '') === 'ADMIN' ? 'selected' : '' ?>>ADMIN</option>
        <option value="OPERATOR" <?= ($user['role'] ?? '') === 'OPERATOR' ? 'selected' : '' ?>>OPERATOR</option>
      </select>
    </div>
  </div>
  <div class="card-footer d-flex justify-content-end gap-2">
    <a class="btn btn-sm btn-secondary" href="/index.php?url=users/index">Kembali</a>
    <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
  </div>
</form>
