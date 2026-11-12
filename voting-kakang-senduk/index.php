<?php
require_once __DIR__ . '/config/koneksi.php';
require_once __DIR__ . '/config/app.php';
$pageTitle = 'Beranda | Kakang Senduk Ponorogo';
$counts = $pdo->query("SELECT kategori, COUNT(*) total FROM kontestan WHERE status='Aktif' GROUP BY kategori")->fetchAll();
$jumlah = ['Kakang' => 0, 'Senduk' => 0];
foreach ($counts as $c) $jumlah[$c['kategori']] = (int)$c['total'];
$period = voting_period($pdo);
$featured = $pdo->query("SELECT * FROM kontestan WHERE status='Aktif' ORDER BY kategori, nomor_peserta LIMIT 3")->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="hero-copy">
    <span class="eyebrow">DUTA WISATA · BUDAYA · GENERASI MUDA</span>
    <h1>Rayakan Pesona Ponorogo.<br><em>Dukung Pilihanmu.</em></h1>
    <p>Kenali para finalis Kakang dan Senduk Ponorogo, telusuri visi-misi mereka, lalu berikan dukunganmu melalui pemilihan digital.</p>
    <div class="hero-actions">
      <a class="btn btn-gold" href="<?= BASE_URL ?>/pages/kontestan.php">Jelajahi Kontestan <span>↗</span></a>
      <a class="btn btn-outline" href="<?= BASE_URL ?>/pages/klasemen.php">Lihat Klasemen</a>
    </div>
    <div class="hero-meta"><span><b><?= $jumlah['Kakang'] ?></b> Kakang</span><span><b><?= $jumlah['Senduk'] ?></b> Senduk</span><span><b><?= $period ? 'AKTIF' : 'TUTUP' ?></b> Voting</span></div>
  </div>
  <div class="hero-art"><div class="sun-disc"></div><div class="hero-frame"><div class="frame-caption">PONOROGO<br><strong>THE CULTURAL SOUL</strong></div><div class="hero-symbol">✦</div></div><div class="floating-tag">01 / GENERASI<br>BERBUDAYA</div></div>
</section>
<section class="section">
  <div class="section-heading"><div><span class="eyebrow">KENALI PARA FINALIS</span><h2>Wajah muda kebanggaan daerah</h2></div><a class="text-link" href="<?= BASE_URL ?>/pages/kontestan.php">Semua kontestan ↗</a></div>
  <div class="candidate-grid">
    <?php foreach ($featured as $k): ?>
      <article class="candidate-card">
        <a class="candidate-photo" href="<?= BASE_URL ?>/pages/detail-kontestan.php?id=<?= (int)$k['id'] ?>">
          <?php if ($k['foto']): ?><img src="<?= BASE_URL ?>/uploads/<?= e($k['foto']) ?>" alt="<?= e($k['nama']) ?>"><?php else: ?><div class="photo-placeholder">KS</div><?php endif; ?>
          <span class="number-badge"><?= e($k['nomor_peserta']) ?></span>
        </a>
        <div class="candidate-info"><span class="category"><?= e($k['kategori']) ?></span><h3><?= e($k['nama']) ?></h3><p><?= e($k['asal_instansi']) ?></p><a class="text-link" href="<?= BASE_URL ?>/pages/detail-kontestan.php?id=<?= (int)$k['id'] ?>">Lihat profil ↗</a></div>
      </article>
    <?php endforeach; ?>
    <?php if (!$featured): ?><div class="empty-state">Data kontestan belum ditambahkan oleh administrator.</div><?php endif; ?>
  </div>
</section>
<section class="callout"><span class="eyebrow">SUARAMU BERARTI</span><h2>Satu suara untuk masa depan pariwisata Ponorogo.</h2><p>Pastikan kamu sudah memiliki akun sebelum memberikan suara.</p><a class="btn btn-gold" href="<?= BASE_URL ?>/pages/voting.php">Voting Sekarang ↗</a></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
