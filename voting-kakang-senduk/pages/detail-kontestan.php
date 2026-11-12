<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/app.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$stmt = $pdo->prepare("SELECT * FROM kontestan WHERE id=? AND status='Aktif'");
$stmt->execute([$id]); $k = $stmt->fetch();
if (!$k) { http_response_code(404); exit('Kontestan tidak ditemukan.'); }
$pageTitle = 'Profil ' . $k['nama'];
require __DIR__ . '/../includes/header.php';
?>
<section class="profile-layout">
<div class="profile-photo"><?php if ($k['foto']): ?><img src="<?= BASE_URL ?>/uploads/<?= e($k['foto']) ?>" alt="<?= e($k['nama']) ?>"><?php else: ?><div class="photo-placeholder">KS</div><?php endif; ?><span class="number-badge"><?= e($k['nomor_peserta']) ?></span></div>
<div class="profile-content"><span class="eyebrow"><?= e($k['kategori']) ?> · FINALIS</span><h1><?= e($k['nama']) ?></h1><p class="lead"><?= e($k['asal_instansi']) ?></p>
<div class="profile-facts"><?php if ($k['tempat_lahir']): ?><div><small>Tempat lahir</small><b><?= e($k['tempat_lahir']) ?></b></div><?php endif; ?><?php if ($k['tanggal_lahir']): ?><div><small>Tanggal lahir</small><b><?= date('d-m-Y', strtotime($k['tanggal_lahir'])) ?></b></div><?php endif; ?></div>
<h3>Visi</h3><p><?= nl2br(e($k['visi'])) ?></p><h3>Misi</h3><p><?= nl2br(e($k['misi'])) ?></p><h3>Prestasi</h3><p><?= nl2br(e($k['prestasi'])) ?></p><h3>Tentang saya</h3><p><?= nl2br(e($k['deskripsi'])) ?></p>
<a class="btn btn-gold" href="voting.php?id=<?= (int)$k['id'] ?>">Dukung kontestan ini ↗</a></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
