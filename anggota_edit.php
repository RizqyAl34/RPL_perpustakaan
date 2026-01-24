<?php
include "../config/koneksi.php";
$id=$_GET['id'];
$a=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM anggota WHERE id_anggota='$id'"));

if(isset($_POST['update'])){
    mysqli_query($koneksi,"
        UPDATE anggota SET
        nama='$_POST[nama]',
        alamat='$_POST[alamat]',
        no_telp='$_POST[no_telp]'
        WHERE id_anggota='$id'
    ");
    header("Location: anggota.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Anggota</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
<h3>Edit Anggota</h3>
<form method="post">
    <input class="form-control mb-2" name="nama" value="<?= $a['nama'] ?>">
    <textarea class="form-control mb-2" name="alamat"><?= $a['alamat'] ?></textarea>
    <input class="form-control mb-3" name="no_telp" value="<?= $a['no_telp'] ?>">
    <button name="update" class="btn btn-warning">Update</button>
</form>
</div>
</body>
</html>
