<?php
session_start();
include "../config/koneksi.php";
if ($_SESSION['role'] != 'anggota') exit;

$user = $_SESSION['id_user'];
$a = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT id_anggota FROM anggota WHERE id_user='$user'
"));

$denda = mysqli_query($koneksi,"
    SELECT d.jumlah_denda, d.status_bayar, p.tanggal_pinjam
    FROM denda d
    JOIN peminjaman p ON d.id_peminjaman = p.id_peminjaman
    WHERE p.id_anggota='$a[id_anggota]'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Status Denda</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
<h3>💰 Status Denda</h3>

<table class="table table-bordered">
<tr class="table-dark">
    <th>No</th>
    <th>Tanggal Pinjam</th>
    <th>Jumlah Denda</th>
    <th>Status</th>
</tr>

<?php $no=1; while($d=mysqli_fetch_assoc($denda)){ ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $d['tanggal_pinjam'] ?></td>
    <td>Rp <?= number_format($d['jumlah_denda']) ?></td>
    <td>
        <span class="badge <?= $d['status_bayar']=='Belum'?'bg-danger':'bg-success' ?>">
            <?= $d['status_bayar'] ?>
        </span>
    </td>
</tr>
<?php } ?>
</table>

<a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>
