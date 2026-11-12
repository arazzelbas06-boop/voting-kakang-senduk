APLIKASI VOTING KAKANG SENDUK PONOROGO
PHP Native + MySQL + PDO + CSS murni (tanpa Bootstrap)

CARA INSTALASI
1. Ekstrak folder voting-kakang-senduk ke C:\xampp\htdocs\
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka http://localhost/phpmyadmin
4. Pilih menu Import, lalu import file database.sql.
5. Jika password MySQL root kamu bukan kosong, ubah config/koneksi.php.
6. Buka http://localhost/voting-kakang-senduk/setup-admin.php untuk membuat admin pertama.
7. Login admin:
   Email    : admin@voting.test
   Password : admin12345
8. SEGERA hapus setup-admin.php setelah akun admin dibuat.
9. Buka http://localhost/voting-kakang-senduk/admin/dashboard.php
10. Tambahkan kontestan dan buat periode voting di menu Periode.
11. Pemilih mendaftar melalui menu Daftar, lalu login dan voting.

CATATAN
- Foto kontestan disimpan di folder uploads.
- Format foto yang diterima JPG, PNG, WEBP maksimal 2 MB.
- Password memakai password_hash() dan password_verify().
- PDO prepared statements digunakan untuk query dengan input pengguna.
- Token CSRF digunakan pada formulir yang mengubah data.
- UNIQUE KEY (user_id, kategori) mencegah voting ganda pada kategori yang sama.
- Voting hanya bisa dilakukan saat periode berstatus Aktif dan waktu server berada di rentang periode.
- Klasemen publik menghitung suara pada periode yang berstatus Aktif.
- Ini adalah starter project pembelajaran. Sebelum dipakai untuk pemilihan resmi, perlu audit keamanan, backup, pengujian beban, kebijakan privasi, dan verifikasi hasil.

STRUKTUR
admin/       Panel administrator
auth/        Registrasi, login, logout
config/      Koneksi dan helper aplikasi
includes/    Header dan footer
pages/       Halaman publik, detail, voting, klasemen
proses/      Proses penyimpanan voting
assets/      CSS dan JavaScript
uploads/     Foto kontestan
database.sql Struktur database
