<?php
session_start();
include "../config/koneksi.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    mysqli_query($koneksi, "
        INSERT INTO buku (judul, pengarang, penerbit, tahun, stok)
        VALUES (
            '$_POST[judul]',
            '$_POST[pengarang]',
            '$_POST[penerbit]',
            '$_POST[tahun]',
            '$_POST[stok]'
        )
    ");
    header("Location: buku.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>➕ Tambah Buku</h3>

    <form method="post">
        <div class="mb-2">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Pengarang</label>
            <input type="text" name="pengarang" class="form-control">
        </div>
        <div class="mb-2">
            <label>Penerbit</label>
            <input type="text" name="penerbit" class="form-control">
        </div>
        <div class="mb-2">
            <label>Tahun</label>
            <input type="number" name="tahun" class="form-control">
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>

        <button name="simpan" class="btn btn-success">Simpan</button>
        <a href="buku.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

</body>
</html>
