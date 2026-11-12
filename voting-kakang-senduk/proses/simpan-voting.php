<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/app.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('pages/voting.php');
verify_csrf();
$userId = (int)current_user()['id'];
$selectedIds = $_POST['kontestan_ids'] ?? [];
$kontestanId = is_array($selectedIds)
    ? (count($selectedIds) === 1 ? (int)$selectedIds[0] : 0)
    : filter_input(INPUT_POST, 'kontestan_id', FILTER_VALIDATE_INT);
try {
    $pdo->beginTransaction();
    $period = voting_period($pdo);
    if (!$period) throw new RuntimeException('Periode voting sedang tidak aktif.');
    $stmt = $pdo->prepare("SELECT id, kategori FROM kontestan WHERE id=? AND status='Aktif' FOR UPDATE");
    $stmt->execute([$kontestanId]); $candidate = $stmt->fetch();
    if (!$candidate) throw new RuntimeException('Kontestan tidak ditemukan atau tidak aktif.');
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM voting WHERE user_id=? AND periode_id=?');
    $stmt->execute([$userId, $period['id']]);
    if ((int)$stmt->fetchColumn() > 0) throw new RuntimeException('Kamu sudah memilih pada periode ini.');
    $stmt = $pdo->prepare('INSERT INTO voting (user_id,kontestan_id,kategori,periode_id) VALUES (?,?,?,?)');
    $stmt->execute([$userId, $candidate['id'], $candidate['kategori'], $period['id']]);
    $pdo->commit();
    set_flash('success', 'Voting berhasil! Terima kasih sudah berpartisipasi.');
} catch (PDOException $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    set_flash('danger', 'Voting gagal disimpan. Silakan coba kembali.');
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    set_flash('warning', $e->getMessage());
}
redirect('pages/voting.php');
