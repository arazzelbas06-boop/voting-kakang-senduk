<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/app.php';
if (is_logged_in()) redirect('index.php');
$error = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $nama=trim($_POST['nama']??''); $email=trim($_POST['email']??''); $hp=trim($_POST['no_hp']??''); $password=$_POST['password']??'';
    if ($nama==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || $hp==='' || strlen($password)<8) $error='Lengkapi data dengan benar. Password minimal 8 karakter.';
    else {
        try {
            $stmt=$pdo->prepare("INSERT INTO users (nama,email,no_hp,password,role) VALUES (?,?,?,?, 'pemilih')");
            $stmt->execute([$nama,$email,$hp,password_hash($password,PASSWORD_DEFAULT)]);
            set_flash('success','Registrasi berhasil. Silakan login.'); redirect('auth/login.php');
        } catch(PDOException $e) { $error=$e->getCode()==='23000'?'Email sudah terdaftar.':'Registrasi gagal.'; }
    }
}
$pageTitle='Registrasi Pemilih'; require __DIR__.'/../includes/header.php';
?>
<div class="auth-wrap"><form class="auth-card" method="post"><span class="eyebrow">BUAT AKUN</span><h1>Daftar sebagai pemilih</h1><p>Isi data berikut untuk ikut berpartisipasi.</p><?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Nama lengkap</label><input name="nama" required maxlength="100" value="<?= e($_POST['nama']??'') ?>"><label>Email</label><input type="email" name="email" required value="<?= e($_POST['email']??'') ?>"><label>Nomor HP</label><input name="no_hp" required value="<?= e($_POST['no_hp']??'') ?>"><label>Password (minimal 8 karakter)</label><input type="password" name="password" required minlength="8"><button class="btn btn-gold btn-full">Buat akun</button><p class="auth-switch">Sudah punya akun? <a href="login.php">Masuk</a></p></form></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
