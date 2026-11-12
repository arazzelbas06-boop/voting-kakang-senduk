<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/app.php';
$pageTitle = 'Daftar Kontestan';
$kategori = $_GET['kategori'] ?? '';
$q = trim($_GET['q'] ?? '');
$sql = "SELECT * FROM kontestan WHERE status='Aktif'";
$params = [];
if (in_array($kategori, ['Kakang','Senduk'], true)) { $sql .= " AND kategori=?"; $params[] = $kategori; }
if ($q !== '') { $sql .= " AND (nama LIKE ? OR nomor_peserta LIKE ? OR asal_instansi LIKE ?)"; array_push($params, "%$q%", "%$q%", "%$q%"); }
$sql .= " ORDER BY kategori, nomor_peserta";
$stmt = $pdo->prepare($sql); $stmt->execute($params); $rows = $stmt->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="page-intro"><span class="eyebrow">PARA FINALIS</span><h1>Daftar Kontestan</h1><p>Kenali sosok, gagasan, dan potensi putra-putri terbaik Ponorogo.</p></section>
<form class="filter-bar" method="get"><input name="q" value="<?= e($q) ?>" placeholder="Cari nama, nomor, atau instansi..."><select name="kategori"><option value="">Semua kategori</option><option <?= $kategori==='Kakang'?'selected':'' ?>>Kakang</option><option <?= $kategori==='Senduk'?'selected':'' ?>>Senduk</option></select><button class="btn btn-dark">Cari</button></form>
<div class="candidate-grid">
<?php foreach ($rows as $k): ?>
<article class="candidate-card">
<a class="candidate-photo" href="detail-kontestan.php?id=<?= (int)$k['id'] ?>"><?php if ($k['foto']): ?><img src="<?= BASE_URL ?>/uploads/<?= e($k['foto']) ?>" alt="<?= e($k['nama']) ?>"><?php else: ?><div class="photo-placeholder">KS</div><?php endif; ?><span class="number-badge"><?= e($k['nomor_peserta']) ?></span></a>
<div class="candidate-info"><span class="category"><?= e($k['kategori']) ?></span><h3><?= e($k['nama']) ?></h3><p><?= e($k['asal_instansi']) ?></p><div class="card-actions"><a class="btn btn-small btn-outline-dark" href="detail-kontestan.php?id=<?= (int)$k['id'] ?>">Detail</a><a class="btn btn-small btn-gold" href="voting.php?id=<?= (int)$k['id'] ?>">Vote</a></div></div>
</article>
<?php endforeach; ?>
<?php if (!$rows): ?><div class="empty-state">Kontestan tidak ditemukan.</div><?php endif; ?>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
