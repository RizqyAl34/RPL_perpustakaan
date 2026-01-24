<?php
session_start();
include "../config/koneksi.php";

if(isset($_POST['pinjam'])){
    mysqli_query($koneksi,"
        INSERT INTO peminjaman (id_anggota,tanggal_pinjam,tanggal_kembali)
        VALUES ('$_POST[id_anggota]',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 7 DAY))
    ");

    $id_peminjaman = mysqli_insert_id($koneksi);

    foreach($_POST['buku'] as $id_buku){
        mysqli_query($koneksi,"
            INSERT INTO detail_peminjaman (id_peminjaman,id_buku,jumlah)
            VALUES ('$id_peminjaman','$id_buku',1)
        ");
        mysqli_query($koneksi,"
            UPDATE buku SET stok = stok-1 WHERE id_buku='$id_buku'
        ");
    }

    echo "<script>alert('Peminjaman berhasil');</script>";
}

$anggota=mysqli_query($koneksi,"SELECT * FROM anggota");
$buku=mysqli_query($koneksi,"SELECT * FROM buku WHERE stok>0");
?>

<!DOCTYPE html>
<html>
<head>
<title>Peminjaman Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
<h3>📝 Peminjaman Buku</h3>

<form method="post">
    <label>Anggota</label>
    <select name="id_anggota" class="form-control mb-3">
        <?php while($a=mysqli_fetch_assoc($anggota)){ ?>
        <option value="<?= $a['id_anggota'] ?>"><?= $a['nama'] ?></option>
        <?php } ?>
    </select>

    <label>Buku</label>
    <?php while($b=mysqli_fetch_assoc($buku)){ ?>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="buku[]" value="<?= $b['id_buku'] ?>">
        <label class="form-check-label">
            <?= $b['judul'] ?> (stok <?= $b['stok'] ?>)
        </label>
    </div>
    <?php } ?>

    <button name="pinjam" class="btn btn-primary mt-3">Proses Peminjaman</button>
</form>

<a href="dashboard.php" class="btn btn-secondary mt-3">Kembali</a>
</div>

</body>
</html>
