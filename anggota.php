<?php
session_start();
include "../config/koneksi.php";
if ($_SESSION['role'] != 'admin') exit;
$data = mysqli_query($koneksi, "SELECT * FROM anggota");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>👥 Data Anggota</h3>
    <a href="anggota_tambah.php" class="btn btn-primary mb-3">+ Tambah Anggota</a>

    <table class="table table-bordered">
        <tr class="table-dark">
            <th>No</th><th>Nama</th><th>Alamat</th><th>No Telp</th><th>Aksi</th>
        </tr>
        <?php $no=1; while($a=mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $a['nama'] ?></td>
            <td><?= $a['alamat'] ?></td>
            <td><?= $a['no_telp'] ?></td>
            <td>
                <a href="anggota_edit.php?id=<?= $a['id_anggota'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="anggota_hapus.php?id=<?= $a['id_anggota'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Hapus data?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
