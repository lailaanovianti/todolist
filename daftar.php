<?php
session_start();
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($nama) || empty($username) || empty($password)) {
        echo '<script>alert("Harap isi semua kolom!"); window.history.back();</script>';
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $cek_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek_username) > 0) {
        echo '<script>alert("Username sudah digunakan, coba yang lain."); window.history.back();</script>';
        exit();
    }

    $query = mysqli_query($koneksi, "INSERT INTO user (nama, username, password) VALUES ('$nama', '$username', '$hashed_password')");

    if ($query) {
        echo '<script>alert("Selamat, pendaftaran anda berhasil. Silahkan login."); location.href="login.php";</script>';
    } else {
        echo '<script>alert("Pendaftaran gagal: ' . mysqli_error($koneksi) . '")</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>HALAMAN REGISTRASI</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8c8dc;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 300px;
    }
    h2 {
        color: #d63384;
        font-weight: bold;
    }
    input {
        width: calc(100% - 20px);
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    button {
        background-color: #d63384;
        color: white;
        border: none;
        padding: 10px;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #c2186b;
    }
    p {
        margin-top: 10px;
    }
    a {
        color: #d63384;
        font-weight: bold;
        text-decoration: none;
    }
</style>

<div class="container">
    <h2>Registrasi</h2>
    <form method="POST" action="">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
</div>

</body>
</html>
