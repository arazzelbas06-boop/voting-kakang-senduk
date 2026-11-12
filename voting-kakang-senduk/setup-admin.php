<?php
require_once __DIR__.'/config/koneksi.php';
require_once __DIR__.'/config/app.php';
$email='admin@voting.test';
$stmt=$pdo->prepare("SELECT id FROM users WHERE email=?");$stmt->execute([$email]);
if($stmt->fetch()){exit('Akun admin sudah tersedia. Hapus file setup-admin.php demi keamanan.');}
$stmt=$pdo->prepare("INSERT INTO users(nama,email,no_hp,password,role) VALUES(?,?,?,?, 'admin')");
$stmt->execute(['Administrator',$email,'080000000000',password_hash('admin12345',PASSWORD_DEFAULT)]);
echo 'Admin berhasil dibuat.<br>Email: admin@voting.test<br>Password: admin12345<br><b>Segera hapus file setup-admin.php setelah digunakan.</b>';
