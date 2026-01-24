<?php
session_start();
include "../config/koneksi.php";

if(isset($_GET['setujui'])){
    $id = $_GET['setujui'];

    mysqli_query($koneksi,"
        UPDATE peminjaman SET approval='Disetujui'
        WHERE id_peminjaman='$id'
    ");

    $detail = mysqli_query($koneksi,"
        SELECT * FROM detail_peminjaman WHERE id_peminjaman='$id'
    ");
    while($d=mysqli_fetch_assoc($detail)){
        mysqli_query($koneksi,"
            UPDATE buku SET stok = stok-1 WHERE id_buku='$d[id_buku]'
        ");
    }
}

$data = mysqli_query($koneksi,"
    SELECT p.id_peminjaman, a.nama, p.tanggal_pinjam, p.approval
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id_anggota
    WHERE p.approval='Menunggu'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Persetujuan Peminjaman</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
<h3>✅ Persetujuan Peminjaman</h3>

<table class="table table-bordered">
<tr class="table-dark">
    <th>Nama</th>
    <th>Tanggal</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php while($r=mysqli_fetch_assoc($data)){ ?>
<tr>
    <td><?= $r['nama'] ?></td>
    <td><?= $r['tanggal_pinjam'] ?></td>
    <td><?= $r['approval'] ?></td>
    <td>
        <a href="?setujui=<?= $r['id_peminjaman'] ?>" 
           class="btn btn-success btn-sm"
           onclick="return confirm('Setujui peminjaman?')">
           Setujui
        </a>
    </td>
</tr>
<?php } ?>
</table>

<a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>
