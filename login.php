<?php
session_start();
include "koneksi.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>HALAMAN FORM LOGIN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<style>
        body {
            background-color: #f8c8dc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }
        h3 {
            color: #d63384;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #d63384;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        a {
            display: block;
            margin-top: 10px;
            color: #d63384;
            text-decoration: none;
        }
    </style>


<?php
if (isset($_POST['username'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo '<script>alert("Username dan password tidak boleh kosong!"); window.history.back();</script>';
        exit();
    }

    // Query untuk mengambil data user berdasarkan username
    $stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $data['password'])) {
            // Menyimpan data user_id dan nama ke sesi
            $_SESSION['user_id'] = $data['id_user'];  // Menyimpan ID user ke sesi
            $_SESSION['user_name'] = $data['nama'];  // Menyimpan nama user ke sesi

            // Redirect ke dashboard atau halaman utama
            echo '<script>alert("Selamat Datang, ' . $data['nama'] . '");
                  location.href="dashboard.php";</script>';
        } else {
            echo '<script>alert("Username atau password salah."); window.history.back();</script>';
        }
    } else {
        echo '<script>alert("Username atau password salah."); window.history.back();</script>';
    }

    $stmt->close();
}
?>

<div class="container">
    <h3>Login</h3>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <a href="daftar.php">Belum punya akun? Daftar</a>
    </form>
</div>
</body>
</html>