<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login - SISPUS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --bs-success:#28a745; }
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
        .background-image {
          background-image: url('/assets/images/background.webp');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
          height: 100vh;
        }
    </style>
</head>
<body class="background-image d-flex align-items-center justify-content-center">
    <div style="width: 100%; max-width: 1000px;">
      <?= $content ?>
      <small class="d-block text-muted mt-3 text-center">&copy; 2025 Sistem Perpustakaan by <strong>Sahal Asshudais</strong></small>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
