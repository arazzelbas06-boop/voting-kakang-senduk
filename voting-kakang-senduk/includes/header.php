<?php
require_once __DIR__ . '/../config/app.php';
$pageTitle = $pageTitle ?? 'Voting Kakang Senduk Ponorogo';
$user = current_user();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?></title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/photo-fix.css">
  <script defer src="<?= BASE_URL ?>/assets/js/app.js ?>"></script>
</head>
<body>
<header class="site-header">
  <a class="brand" href="<?= BASE_URL ?>/index.php"><span class="brand-mark">KS</span><span><b>KAKANG SENDUK</b><small>PONOROGO · PEMILIHAN DUTA WISATA</small></span></a>
  <button class="menu-toggle" aria-label="Buka navigasi" onclick="document.querySelector('.nav-links').classList.toggle('show')">☰</button>
  <nav class="nav-links">
    <a href="<?= BASE_URL ?>/index.php">Beranda</a>
    <a href="<?= BASE_URL ?>/pages/kontestan.php">Kontestan</a>
    <a href="<?= BASE_URL ?>/pages/klasemen.php">Klasemen</a>
    <?php if ($user && $user['role'] === 'admin'): ?>
      <a href="<?= BASE_URL ?>/admin/dashboard.php">Dashboard</a>
    <?php endif; ?>
    <?php if ($user): ?>
      <span class="nav-user"><?= e($user['nama']) ?></span>
      <a class="nav-cta" href="<?= BASE_URL ?>/auth/logout.php">Keluar</a>
    <?php else: ?>
      <a href="<?= BASE_URL ?>/auth/login.php">Masuk</a>
      <a class="nav-cta" href="<?= BASE_URL ?>/auth/register.php">Daftar</a>
    <?php endif; ?>
  </nav>
</header>
<main class="main-wrap">
<?php if ($flash = get_flash()): ?>
  <div class="alert alert-<?= e($flash['type']) ?><?= $flash['type'] === 'success' ? ' vote-success' : '' ?>"<?= $flash['type'] === 'success' ? ' data-vote-success' : '' ?>><?= e($flash['message']) ?></div>
<?php endif; ?>
