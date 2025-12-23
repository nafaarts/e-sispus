<!-- Halaman Login -->
<div class="row justify-content-center">
  <div class="col-md-6">
    <center>
      <!-- Logo Aplikasi -->
      <img src="/assets/images/logo.png" alt="Logo E-Perpus" class="img-fluid mb-4" style="max-height: 100px;">
    </center>
    <div class="card border-0">
      <div class="card-body px-4 pt-5 pb-4">
        <div class="text-center">
          <h3 class="mb-3">Masuk ke SISPUS</h3>
          <p>Silahkan masukkan email dan password Anda.</p>
        </div>
        
        <!-- Tampilkan pesan error jika ada -->
        <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <!-- Form Login -->
        <form method="post" action="/index.php?url=auth/doLogin">
          <!-- Token CSRF untuk keamanan -->
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
          
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" required placeholder="Masukkan email">
          </div>
          
          <div class="mb-5">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" required placeholder="Masukkan password">
          </div>
          
          <button class="btn btn-success" type="submit">Masuk</button>
        </form>
      </div>
    </div>
  </div>
</div>

