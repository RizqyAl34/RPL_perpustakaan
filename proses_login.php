<?php
session_start();
include "../config/koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi,
    "SELECT * FROM users WHERE username='$username' AND password='$password'"
);

$data = mysqli_fetch_assoc($query);

if ($data) {
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    if ($data['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../anggota/dashboard.php");
    }
} else {
    echo "<script>
            alert('Login gagal!');
            window.location='login.php';
          </script>";
}
