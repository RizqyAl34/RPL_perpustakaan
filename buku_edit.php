<?php
session_start();
include "../config/koneksi.php";

$id = $_GET['id'];
$buku = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id'")
);

if (isset($_POST['update'])) {
    mysqli_query($koneksi, "
        UPDATE buku SET
        judul='$_POST[judul]',
        pengarang='$_POST[pengarang]',
        penerbit='$_POST[penerbit]',
        tahun='$_POST[tahun]',
        stok='$_POST[stok]'
        WHERE id_buku='$id'
    ");
    header("Location: buku.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>✏ Edit Buku</h3>

    <form method="post">
        <input type="text" name="judul" value="<?= $buku['judul'] ?>" class="form-control mb-2">
        <input type="text" name="pengarang" value="<?= $buku['pengarang'] ?>" class="form-control mb-2">
        <input type="text" name="penerbit" value="<?= $buku['penerbit'] ?>" class="form-control mb-2">
        <input type="number" name="tahun" value="<?= $buku['tahun'] ?>" class="form-control mb-2">
        <input type="number" name="stok" value="<?= $buku['stok'] ?>" class="form-control mb-3">

        <button name="update" class="btn btn-warning">Update</button>
        <a href="buku.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

</body>
</html>
