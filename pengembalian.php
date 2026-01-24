<?php
session_start();
include "../config/koneksi.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // ambil data peminjaman
    $pinjam = mysqli_fetch_assoc(mysqli_query($koneksi,"
        SELECT * FROM peminjaman WHERE id_peminjaman='$id'
    "));

    $tgl_kembali = date('Y-m-d');
    $terlambat = (strtotime($tgl_kembali) - strtotime($pinjam['tanggal_kembali'])) / (60*60*24);
    $denda = ($terlambat > 0) ? $terlambat * 2000 : 0;

    // update status
    mysqli_query($koneksi,"
        UPDATE peminjaman SET status='Dikembalikan'
        WHERE id_peminjaman='$id'
    ");

    // kembalikan stok buku
    $detail = mysqli_query($koneksi,"
        SELECT * FROM detail_peminjaman WHERE id_peminjaman='$id'
    ");
    while($d=mysqli_fetch_assoc($detail)){
        mysqli_query($koneksi,"
            UPDATE buku SET stok = stok + 1 WHERE id_buku='$d[id_buku]'
        ");
    }

    // simpan denda
    if($denda > 0){
        mysqli_query($koneksi,"
            INSERT INTO denda (id_peminjaman,jumlah_denda,status_bayar)
            VALUES ('$id','$denda','Belum')
        ");
    }

    header("Location: laporan.php");
}
