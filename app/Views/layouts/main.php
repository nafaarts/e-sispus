<?php
// Ambil data user dari session
use Core\Auth;
$user = Auth::user();
$role = $user['role'] ?? 'OPERATOR';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SISPUS - Sistem Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Table CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.26.0/dist/bootstrap-table.min.css">
    <style>
        /* Custom CSS Variables */
        :root { --bs-success:#28a745; }
        .navbar { background-color: #fff; }
        .navbar .nav-link:hover { color: #28a745; }
        /* Override primary button style */
        .btn-primary {
          --bs-btn-color: #fff;
          --bs-btn-bg: var(--bs-success);
          --bs-btn-border-color: var(--bs-success);
          --bs-btn-hover-color: #fff;
          --bs-btn-hover-bg: #218838;
          --bs-btn-hover-border-color: #1e7e34;
          --bs-btn-focus-shadow-rgb: 60,153,110;
          --bs-btn-active-color: #fff;
          --bs-btn-active-bg: #1e7e34;
          --bs-btn-active-border-color: #1c7430;
          --bs-btn-disabled-bg: var(--bs-success);
          --bs-btn-disabled-border-color: var(--bs-success);
        }
        /* Background Image Styling */
        .background-image {
          background-image: url('/assets/images/background.webp');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
          height: 100vh;
        }
    </style>
</head>
<body class="background-image">
<div class="container">
  <!-- Navbar Navigation -->
  <nav class="navbar navbar-ligth navbar-expand-lg px-4 mt-4 rounded-3 shadow-lg">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/index.php?url=home/index">
      <img src="/assets/images/logo.png" alt="" height="30">
      <span class="fs-4 fw-semibold">SISPUS</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <!-- Menu Dashboard -->
        <li class="nav-item"><a class="nav-link" href="/index.php?url=home/index">Dashboard</a></li>
        
        <!-- Menu Peminjaman -->
        <li class="nav-item"><a class="nav-link" href="/index.php?url=peminjaman/index">Peminjaman</a></li>
        
        <!-- Menu Master Data (Khusus Admin) -->
        <?php if ($role === 'ADMIN'): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Master Data</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/index.php?url=users/index">Pengguna</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/index.php?url=kelas/index">Data Kelas</a></li>
            <li><a class="dropdown-item" href="/index.php?url=siswa/index">Data Siswa</a></li>
            <li><a class="dropdown-item" href="/index.php?url=rak/index">Data Rak</a></li>
            <li><a class="dropdown-item" href="/index.php?url=buku/index">Data Buku</a></li>
          </ul>
        </li>
        <?php endif; ?>
        
        <!-- Menu Logout -->
        <li class="nav-item">
          <a class="nav-link" href="/index.php?url=auth/logout" title="Logout">
            Keluar <span class="d-none d-md-inline">(<?= htmlspecialchars($user['name'] ?? 'Guest') ?>)</span>
          </a>
        </li>
      </ul>
    </div>
</nav>
</div>
<main class="container py-4">
    <!-- Content Placeholder -->
    <?= $content ?>
    <!-- Footer -->
    <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
      <small class="d-block text-muted mt-3">&copy; 2025 Sistem Perpustakaan - SD Negeri 48 Banda Aceh</small>
      <small class="d-block text-muted mt-3">oleh <strong>Sahal Asshudais</strong></small>
    </div>
</main>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.26.0/dist/bootstrap-table.min.js"></script>
<script>
  (function() {
    // Inisialisasi Bootstrap Table
    function initTables() {
      $(function() {
        $('table.table').each(function() {
          var $tbl = $(this);
          // Skip jika ada class no-datatable
          if ($tbl.hasClass('no-datatable')) return;
          // Skip jika sudah diinisialisasi
          if ($tbl.data('btInit') === 1) return;
          try {
            $tbl.attr('data-toggle', 'table');
            $tbl.bootstrapTable({
              search: true,
              pagination: true,
              pageSize: 10,
              pageList: [10, 25, 50, 100],
              classes: 'table table-striped table-hover table-sm'
            });
            $tbl.data('btInit', 1);
          } catch (e) {
            console.warn('Tabel tidak dapat diinisialisasi', e);
          }
        });
      });
    }
    initTables();
  })();
</script>
</body>
</html>
