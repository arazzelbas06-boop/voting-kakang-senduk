<?php
// Form bersama untuk tambah dan edit kontestan. Variabel $data dan $editing disiapkan halaman pemanggil.
?>
<form class="admin-form" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Nomor peserta</label><input name="nomor_peserta" required maxlength="10" value="<?= e($data['nomor_peserta']??'') ?>">
<label>Nama lengkap</label><input name="nama" required maxlength="100" value="<?= e($data['nama']??'') ?>">
<label>Kategori</label><select name="kategori"><option <?= ($data['kategori']??'')==='Kakang'?'selected':'' ?>>Kakang</option><option <?= ($data['kategori']??'')==='Senduk'?'selected':'' ?>>Senduk</option></select>
<label>Asal sekolah/instansi</label><input name="asal_instansi" required value="<?= e($data['asal_instansi']??'') ?>">
<label>Tempat lahir</label><input name="tempat_lahir" value="<?= e($data['tempat_lahir']??'') ?>">
<label>Tanggal lahir</label><input type="date" name="tanggal_lahir" value="<?= e($data['tanggal_lahir']??'') ?>">
<label>Foto kontestan (JPG, PNG, WEBP maks. 2 MB)</label><input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp">
<label>Visi</label><textarea name="visi" rows="3"><?= e($data['visi']??'') ?></textarea>
<label>Misi</label><textarea name="misi" rows="4"><?= e($data['misi']??'') ?></textarea>
<label>Prestasi</label><textarea name="prestasi" rows="3"><?= e($data['prestasi']??'') ?></textarea>
<label>Deskripsi profil</label><textarea name="deskripsi" rows="4"><?= e($data['deskripsi']??'') ?></textarea>
<button class="btn btn-gold"><?= $editing?'Simpan perubahan':'Simpan kontestan' ?></button>
</form>
