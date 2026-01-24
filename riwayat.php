<?php
session_start();
include "../config/koneksi.php";
if ($_SESSION['role'] != 'anggota') exit;

// cari id_anggota dari user login
$user = $_SESSION['id_user'];
$a = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT id_anggota FROM anggota WHERE id_user='$user'
"));

$data = mysqli_query($koneksi,"
    SELECT * FROM peminjaman
    WHERE id_anggota='$a[id_anggota]'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Riwayat Peminjaman</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
<h3>📝 Riwayat Peminjaman</h3>

<table class="table table-bordered">
<tr class="table-dark">
    <th>No</th>
    <th>Tanggal Pinjam</th>
    <th>Tanggal Kembali</th>
    <th>Status</th>
</tr>

<?php $no=1; while($r=mysqli_fetch_assoc($data)){ ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $r['tanggal_pinjam'] ?></td>
    <td><?= $r['tanggal_kembali'] ?></td>
    <td>
        <span class="badge <?= $r['status']=='Dipinjam'?'bg-warning':'bg-success' ?>">
            <?= $r['status'] ?>
        </span>
    </td>
</tr>
<?php } ?>
</table>

<a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>
