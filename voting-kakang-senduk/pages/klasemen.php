<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/app.php';
$period = $pdo->query("SELECT * FROM periode_voting WHERE status='Aktif' ORDER BY id DESC LIMIT 1")->fetch();
$periodeId = $period ? (int)$period['id'] : 0;
$stmt = $pdo->prepare("SELECT k.*, COUNT(v.id) total_suara FROM kontestan k LEFT JOIN voting v ON v.kontestan_id=k.id AND v.periode_id=? WHERE k.status='Aktif' GROUP BY k.id ORDER BY k.kategori, total_suara DESC, k.nomor_peserta");
$stmt->execute([$periodeId]); $rows = $stmt->fetchAll();
$grouped = ['Kakang'=>[], 'Senduk'=>[]];
foreach ($rows as $r) $grouped[$r['kategori']][] = $r;
$pageTitle = 'Klasemen Voting';
require __DIR__ . '/../includes/header.php';
?>
<section class="page-intro"><span class="eyebrow">PEROLEHAN SUARA</span><h1>Klasemen Sementara</h1><p>Hasil dihitung otomatis dari suara yang tersimpan pada periode aktif.</p></section>
<?php foreach ($grouped as $cat => $list): $total = array_sum(array_column($list,'total_suara')); ?>
<section class="section compact-section"><div class="section-heading"><div><span class="eyebrow">RANKING</span><h2><?= $cat ?></h2></div><span class="total-votes"><?= number_format($total) ?> suara</span></div>
<div class="leaderboard">
<?php foreach ($list as $i => $k): $percent = $total > 0 ? ((int)$k['total_suara']/$total)*100 : 0; ?>
<div class="rank-row"><div class="rank-number"><?= $i+1 ?></div><div class="rank-avatar"><?php if ($k['foto']): ?><img src="<?= BASE_URL ?>/uploads/<?= e($k['foto']) ?>" alt=""><?php else: ?>KS<?php endif; ?></div><div class="rank-name"><b><?= e($k['nama']) ?></b><small><?= e($k['nomor_peserta']) ?> · <?= e($k['asal_instansi']) ?></small><div class="progress"><span style="width:<?= number_format($percent,2,'.','') ?>%"></span></div></div><div class="rank-score"><b><?= number_format((int)$k['total_suara']) ?></b><small><?= number_format($percent,1) ?>%</small></div></div>
<?php endforeach; ?>
<?php if (!$list): ?><div class="empty-state">Belum ada kontestan.</div><?php endif; ?>
</div></section>
<?php endforeach; ?>
<p class="muted center">Data klasemen diperbarui setiap kali halaman dibuka. Hasil ini bersifat sementara.</p>
<?php require __DIR__ . '/../includes/footer.php'; ?>
