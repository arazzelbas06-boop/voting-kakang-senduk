<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/app.php';
require_login();
$period = voting_period($pdo);
$rows = $pdo->query("SELECT * FROM kontestan WHERE status='Aktif' ORDER BY kategori, nomor_peserta")->fetchAll();
$hasVoted = false;
if ($period) {
    $votes = $pdo->prepare('SELECT COUNT(*) FROM voting WHERE user_id=? AND periode_id=?');
    $votes->execute([current_user()['id'], $period['id']]);
    $hasVoted = (int)$votes->fetchColumn() > 0;
}
$pageTitle = 'Berikan Suara';
require __DIR__ . '/../includes/header.php';
?>
<section class="page-intro"><span class="eyebrow">PARTISIPASI DIGITAL</span><h1>Berikan Suaramu</h1><p>Pilih satu kontestan yang ingin kamu dukung.</p></section>
<?php if (!$period): ?><div class="alert alert-warning">Voting sedang tidak tersedia. Periksa jadwal periode pemilihan.</div>
<?php elseif ($hasVoted): ?><div class="alert alert-success">Voting kamu pada periode ini sudah tercatat.</div>
<?php else: ?>
<form method="post" action="<?= BASE_URL ?>/proses/simpan-voting.php" id="bulk-vote-form" onsubmit="return confirm('Kirim semua pilihan sekarang? Pilihan tidak dapat diubah.');">
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<?php foreach (['Kakang','Senduk'] as $cat): ?>
<section class="section compact-section"><div class="section-heading"><div><span class="eyebrow">KATEGORI</span><h2><?= $cat ?></h2></div><span class="status-pill">PILIH SESUAI KEINGINAN</span></div>
<div class="candidate-grid">
<?php foreach ($rows as $k): if ($k['kategori'] !== $cat) continue; ?>
<label class="candidate-card vote-option"><input class="candidate-checkbox" type="checkbox" name="kontestan_ids[]" value="<?= (int)$k['id'] ?>"><div class="candidate-photo"><?php if ($k['foto']): ?><img src="<?= BASE_URL ?>/uploads/<?= e($k['foto']) ?>" alt="<?= e($k['nama']) ?>"><?php else: ?><div class="photo-placeholder">KS</div><?php endif; ?><span class="number-badge"><?= e($k['nomor_peserta']) ?></span><span class="check-mark">✓</span></div><div class="candidate-info"><h3><?= e($k['nama']) ?></h3><p><?= e($k['asal_instansi']) ?></p><span class="btn btn-small btn-outline-dark">Pilih kontestan</span></div></label>
<?php endforeach; ?>
</div></section>
<?php endforeach; ?>
<div class="vote-submit-wrap"><button class="btn btn-gold" type="submit">Kirim semua pilihan</button><span id="vote-selection-count">0 kontestan dipilih</span></div>
</form>
<?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
