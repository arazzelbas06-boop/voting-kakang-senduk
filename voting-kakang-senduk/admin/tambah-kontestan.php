<?php
require_once __DIR__.'/../config/koneksi.php';require_once __DIR__.'/../config/app.php';require_admin();
$data=[];$editing=false;$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();$foto=null;
 if(!empty($_FILES['foto']['name'])){$f=$_FILES['foto'];$mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);$allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];if($f['size']>2*1024*1024||!isset($allowed[$mime]))$error='Foto harus JPG, PNG, atau WEBP maksimal 2 MB.';else{$foto=bin2hex(random_bytes(12)).'.'.$allowed[$mime];move_uploaded_file($f['tmp_name'],__DIR__.'/../uploads/'.$foto);}}
 if(!$error){$stmt=$pdo->prepare("INSERT INTO kontestan(nomor_peserta,nama,kategori,foto,tempat_lahir,tanggal_lahir,asal_instansi,visi,misi,prestasi,deskripsi) VALUES(?,?,?,?,?,?,?,?,?,?,?)");try{$stmt->execute([trim($_POST['nomor_peserta']),trim($_POST['nama']),$_POST['kategori'],$foto,trim($_POST['tempat_lahir']??''),($_POST['tanggal_lahir']??'')?:null,trim($_POST['asal_instansi']),trim($_POST['visi']??''),trim($_POST['misi']??''),trim($_POST['prestasi']??''),trim($_POST['deskripsi']??'')]);set_flash('success','Kontestan berhasil ditambahkan.');redirect('admin/kontestan.php');}catch(PDOException $e){$error='Gagal menyimpan. Pastikan nomor peserta belum digunakan.';}}
 $data=$_POST;
}
$pageTitle='Tambah Kontestan';require __DIR__.'/../includes/header.php';?><section class="page-intro"><h1>Tambah Kontestan</h1></section><div class="admin-panel"><?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><?php require __DIR__.'/form-kontestan.php'; ?></div><?php require __DIR__.'/../includes/footer.php';?>
