<?php
session_start();
include "../config/koneksi.php";

// Ambil semua data peminjaman + denda (jika ada)
$data = mysqli_query($koneksi,"
    SELECT 
        p.id_peminjaman,
        a.nama,
        p.tanggal_pinjam,
        p.tanggal_kembali,
        p.status,
        p.approval,
        IFNULL(d.jumlah_denda,0) AS denda
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id_anggota
    LEFT JOIN denda d ON p.id_peminjaman = d.id_peminjaman
    ORDER BY p.tanggal_pinjam DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3 class="mb-3">📊 Laporan Peminjaman Buku</h3>

    <table class="table table-bordered table-striped align-middle">
        <tr class="table-dark text-center">
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Approval</th>
            <th>Denda</th>
            <th>Aksi</th>
        </tr>

        <?php $no=1; while($r=mysqli_fetch_assoc($data)){ ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>

            <td><?= $r['nama'] ?></td>

            <td class="text-center"><?= $r['tanggal_pinjam'] ?></td>

            <td class="text-center"><?= $r['tanggal_kembali'] ?></td>

            <!-- STATUS PINJAM -->
            <td class="text-center">
                <?php if($r['status']=='Dipinjam'){ ?>
                    <span class="badge bg-warning">Dipinjam</span>
                <?php } else { ?>
                    <span class="badge bg-success">Dikembalikan</span>
                <?php } ?>
            </td>

            <!-- APPROVAL -->
            <td class="text-center">
                <?php
                if($r['approval']=='Menunggu'){
                    echo "<span class='badge bg-warning'>Menunggu</span>";
                }elseif($r['approval']=='Disetujui'){
                    echo "<span class='badge bg-success'>Disetujui</span>";
                }else{
                    echo "<span class='badge bg-danger'>Ditolak</span>";
                }
                ?>
            </td>

            <!-- DENDA -->
            <td class="text-end">
                Rp <?= number_format($r['denda'],0,',','.') ?>
            </td>

            <!-- AKSI -->
            <td class="text-center">

                <?php if($r['approval']=='Menunggu'){ ?>
                    <a href="setujui.php?id=<?= $r['id_peminjaman'] ?>"
                       class="btn btn-success btn-sm"
                       onclick="return confirm('Setujui peminjaman ini?')">
                       Setujui
                    </a>

                <?php } elseif($r['status']=='Dipinjam'){ ?>
                    <a href="pengembalian.php?id=<?= $r['id_peminjaman'] ?>"
                       class="btn btn-primary btn-sm"
                       onclick="return confirm('Proses pengembalian buku?')">
                       Kembalikan
                    </a>

                <?php } else { ?>
                    <span class="text-muted">-</span>
                <?php } ?>

            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">⬅ Kembali</a>
</div>

</body>
</html>
