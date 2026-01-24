<?php
include "../config/koneksi.php";

$id = $_GET['id'];

mysqli_query($koneksi,"
    UPDATE peminjaman 
    SET approval='Disetujui', status='Dipinjam'
    WHERE id_peminjaman='$id'
");

$detail = mysqli_query($koneksi,"
    SELECT * FROM detail_peminjaman WHERE id_peminjaman='$id'
");

while($d=mysqli_fetch_assoc($detail)){
    mysqli_query($koneksi,"
        UPDATE buku SET stok = stok - 1 WHERE id_buku='$d[id_buku]'
    ");
}

header("Location: laporan.php");
