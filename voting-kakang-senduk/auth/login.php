<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/app.php';
if (is_logged_in()) redirect(current_user()['role']==='admin'?'admin/dashboard.php':'index.php');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $email=trim($_POST['email']??''); $password=$_POST['password']??'';
 $stmt=$pdo->prepare("SELECT id,nama,email,password,role FROM users WHERE email=? LIMIT 1"); $stmt->execute([$email]); $u=$stmt->fetch();
 if($u && password_verify($password,$u['password'])){
  session_regenerate_id(true); unset($u['password']); $_SESSION['user']=$u;
  redirect($u['role']==='admin'?'admin/dashboard.php':'index.php');
 } else $error='Email atau password salah.';
}
$pageTitle='Login'; require __DIR__.'/../includes/header.php';
?>
<div class="auth-wrap"><form class="auth-card" method="post"><span class="eyebrow">SELAMAT DATANG</span><h1>Masuk ke akunmu</h1><p>Login untuk memberikan dukungan kepada finalis pilihanmu.</p><?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Email</label><input type="email" name="email" required><label>Password</label><input type="password" name="password" required><button class="btn btn-gold btn-full">Masuk</button><p class="auth-switch">Belum punya akun? <a href="register.php">Daftar sekarang</a></p></form></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
