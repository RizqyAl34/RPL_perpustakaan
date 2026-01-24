<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'anggota') {
    exit;
}

$id_user = $_SESSION['id_user'];

$a = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT id_anggota FROM anggota WHERE id_user='$id_user'
"));

if (isset($_POST['ajukan'])) {

    if (!isset($_POST['buku']) || empty($_POST['buku'])) {
        echo "<script>alert('Pilih minimal 1 buku untuk dipinjam');</script>";
    } 
    elseif (count($_POST['buku']) > 3) {
        echo "<script>alert('Maksimal meminjam 3 buku');</script>";
    } 
    else {

        mysqli_query($koneksi,"
            INSERT INTO peminjaman 
            (id_anggota, tanggal_pinjam, tanggal_kembali, status, approval)
            VALUES (
                '$a[id_anggota]',
                CURDATE(),
                DATE_ADD(CURDATE(), INTERVAL 7 DAY),
                'Dipinjam',
                'Menunggu'
            )
        ");

        $id_peminjaman = mysqli_insert_id($koneksi);

        foreach ($_POST['buku'] as $id_buku) {
            mysqli_query($koneksi,"
                INSERT INTO detail_peminjaman (id_peminjaman, id_buku, jumlah)
                VALUES ('$id_peminjaman', '$id_buku', 1)
            ");
        }

        echo "<script>
            alert('Pengajuan peminjaman berhasil, menunggu persetujuan admin');
            window.location='dashboard.php';
        </script>";
    }
}

$buku = mysqli_query($koneksi,"
    SELECT * FROM buku WHERE stok > 0
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajukan Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3 class="mb-3">📥 Ajukan Peminjaman Buku</h3>

    <form method="post">
        <div class="row">

            <?php while($b = mysqli_fetch_assoc($buku)){ ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="buku[]"
                                   value="<?= $b['id_buku'] ?>"
                                   id="buku<?= $b['id_buku'] ?>">

                            <label class="form-check-label fw-bold"
                                   for="buku<?= $b['id_buku'] ?>">
                                <?= $b['judul'] ?>
                            </label>
                        </div>

                        <hr class="my-2">

                        <p class="mb-1">
                            <strong>Pengarang:</strong> <?= $b['pengarang'] ?>
                        </p>
                        <p class="mb-1">
                            <strong>Tahun:</strong> <?= $b['tahun'] ?>
                        </p>
                        <p class="mb-0">
                            <strong>Stok:</strong>
                            <span class="badge bg-success"><?= $b['stok'] ?></span>
                        </p>

                    </div>
                </div>
            </div>
            <?php } ?>

        </div>

        <button type="submit" name="ajukan" class="btn btn-primary mt-3">
            📥 Ajukan Peminjaman
        </button>

        <a href="dashboard.php" class="btn btn-secondary mt-3">
            ⬅ Kembali
        </a>
    </form>
</div>

</body>
</html>
