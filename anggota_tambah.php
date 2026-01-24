<?php
session_start();
include "../config/koneksi.php";
if (isset($_POST['simpan'])) {
    mysqli_query($koneksi,"
        INSERT INTO anggota (id_user,nama,alamat,no_telp)
        VALUES (NULL,'$_POST[nama]','$_POST[alamat]','$_POST[no_telp]')
    ");
    header("Location: anggota.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Anggota</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
<h3>Tambah Anggota</h3>
<form method="post">
    <input class="form-control mb-2" name="nama" placeholder="Nama" required>
    <textarea class="form-control mb-2" name="alamat" placeholder="Alamat"></textarea>
    <input class="form-control mb-3" name="no_telp" placeholder="No Telp">
    <button name="simpan" class="btn btn-success">Simpan</button>
</form>
</div>
</body>
</html>
