<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        a.card-link {
            text-decoration: none;
            color: inherit;
        }
        a.card-link:hover .card {
            transform: scale(1.03);
            transition: 0.3s;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Admin Perpustakaan</span>
        <a href="../auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <h4>Selamat datang, <?= $_SESSION['username']; ?></h4>

    <div class="row mt-4">

        <!-- DATA BUKU -->
        <div class="col-md-3">
            <a href="buku.php" class="card-link">
                <div class="card text-bg-primary mb-3 text-center">
                    <div class="card-body">
                        <h5>📚 Data Buku</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- DATA ANGGOTA -->
        <div class="col-md-3">
            <a href="anggota.php" class="card-link">
                <div class="card text-bg-success mb-3 text-center">
                    <div class="card-body">
                        <h5>👥 Data Anggota</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- PEMINJAMAN -->
        <div class="col-md-3">
            <a href="peminjaman.php" class="card-link">
                <div class="card text-bg-warning mb-3 text-center">
                    <div class="card-body">
                        <h5>📝 Peminjaman</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- LAPORAN -->
        <div class="col-md-3">
            <a href="laporan.php" class="card-link">
                <div class="card text-bg-danger mb-3 text-center">
                    <div class="card-body">
                        <h5>📊 Laporan</h5>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

</body>
</html>
