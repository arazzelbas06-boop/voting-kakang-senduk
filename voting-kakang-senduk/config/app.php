<?php
declare(strict_types=1);

date_default_timezone_set('Asia/Jakarta');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', '/voting-kakang-senduk');

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
function redirect(string $path): never {
    header('Location: ' . BASE_URL . '/' . ltrim($path, '/'));
    exit;
}
function is_logged_in(): bool {
    return isset($_SESSION['user']);
}
function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}
function require_login(): void {
    if (!is_logged_in()) {
        set_flash('warning', 'Silakan login terlebih dahulu.');
        redirect('auth/login.php');
    }
}
function require_admin(): void {
    require_login();
    if (($_SESSION['user']['role'] ?? '') !== 'admin') {
        http_response_code(403);
        exit('Akses ditolak. Halaman ini khusus administrator.');
    }
}
function set_flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}
function get_flash(): ?array {
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    $token = $_POST['csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(419);
        exit('Permintaan tidak valid. Muat ulang halaman dan coba lagi.');
    }
}
function voting_period(PDO $pdo): ?array {
    $stmt = $pdo->query("SELECT * FROM periode_voting WHERE status='Aktif' ORDER BY id DESC LIMIT 1");
    $period = $stmt->fetch();
    if (!$period) return null;
    $now = date('Y-m-d H:i:s');
    return ($now >= $period['tanggal_mulai'] && $now <= $period['tanggal_selesai']) ? $period : null;
}
