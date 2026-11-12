<?php
require_once __DIR__.'/../config/koneksi.php'; require_once __DIR__.'/../config/app.php'; require_admin();
$stats=[
 'kontestan'=>(int)$pdo->query("SELECT COUNT(*) FROM kontestan")->fetchColumn(),
 'pemilih'=>(int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='pemilih'")->fetchColumn(),
 'kakang'=>(int)$pdo->query("SELECT COUNT(*) FROM voting WHERE kategori='Kakang'")->fetchColumn(),
 'senduk'=>(int)$pdo->query("SELECT COUNT(*) FROM voting WHERE kategori='Senduk'")->fetchColumn()
];
$period=$pdo->query("SELECT * FROM periode_voting ORDER BY id DESC LIMIT 1")->fetch();
$pageTitle='Dashboard Admin'; require __DIR__.'/../includes/header.php';
?>
<section class="page-intro"><span class="eyebrow">PANEL ADMINISTRATOR</span><h1>Dashboard</h1><p>Ringkasan pengelolaan Pemilihan Kakang Senduk Ponorogo.</p></section>
<div class="admin-nav"><a class="active" href="dashboard.php">Dashboard</a><a href="kontestan.php">Kontestan</a><a href="pemilih.php">Pemilih</a><a href="periode.php">Periode</a><a href="hasil-voting.php">Hasil voting</a></div>
<div class="stats-grid"><div class="stat-card"><small>Total kontestan</small><strong><?= $stats['kontestan'] ?></strong></div><div class="stat-card"><small>Total pemilih</small><strong><?= $stats['pemilih'] ?></strong></div><div class="stat-card"><small>Suara Kakang</small><strong><?= $stats['kakang'] ?></strong></div><div class="stat-card"><small>Suara Senduk</small><strong><?= $stats['senduk'] ?></strong></div></div>
<div class="admin-panel"><h2>Periode voting terakhir</h2><?php if($period): ?><p><b><?= e($period['nama_periode']) ?></b></p><p><?= date('d M Y H:i',strtotime($period['tanggal_mulai'])) ?> – <?= date('d M Y H:i',strtotime($period['tanggal_selesai'])) ?></p><span class="status-pill"><?= e($period['status']) ?></span><?php else: ?><p>Belum ada periode voting. <a href="periode.php">Buat periode</a>.</p><?php endif; ?></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
