<?php
session_start();
include "../config/koneksi.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "SELECT * FROM buku");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>📚 Data Buku</h3>
    <a href="buku_tambah.php" class="btn btn-primary mb-3">+ Tambah Buku</a>

    <table class="table table-bordered table-striped">
        <tr class="table-dark">
            <th>No</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php $no=1; while($row=mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['judul'] ?></td>
            <td><?= $row['pengarang'] ?></td>
            <td><?= $row['penerbit'] ?></td>
            <td><?= $row['tahun'] ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <a href="buku_edit.php?id=<?= $row['id_buku'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="buku_hapus.php?id=<?= $row['id_buku'] ?>" 
                   onclick="return confirm('Hapus buku ini?')" 
                   class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>
