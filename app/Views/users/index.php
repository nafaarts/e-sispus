<div class="card shadow-lg border-0">
  <div class="card-header d-flex justify-content-between align-items-center">
    <p class="mb-0 fw-bold">Daftar Pengguna</p>
    <!-- Tombol tambah pengguna baru -->
    <a class="btn btn-sm btn-primary" href="/index.php?url=users/create">Tambah Pengguna</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
    <!-- Tabel data pengguna -->
    <table class="table table-striped table-hover mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop data pengguna -->
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= (int)$u['id'] ?></td>
            <td><?= htmlspecialchars($u['username'] ?? '') ?></td>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['role'] ?? '') ?></td>
            <td class="text-end">
              <!-- Tombol aksi edit dan hapus -->
              <a class="btn btn-sm btn-warning" href="/index.php?url=users/edit/<?= (int)$u['id'] ?>">Edit</a>
              <form method="post" action="/index.php?url=users/destroy/<?= (int)$u['id'] ?>" style="display:inline">
                <!-- CSRF Token -->
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\Core\Csrf::token()) ?>">
                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Hapus pengguna ini?')">Hapus</button>
              </form>
            </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  </div>
</div>
