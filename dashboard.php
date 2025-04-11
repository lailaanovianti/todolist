<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DASBOARD</title>
    <style>
body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #ffd6e0, #fff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background:rgb(255, 182, 193);
            border: 3px solid pink;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            width: 500px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
        }
        h3 {
            font-size: 24px;
            font-weight: bold;
        }
        p {
            font-size: 20px;
            margin: 20px 0;
        }
        a {
            font-size: 22px;
            font-weight: bold;
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        a:hover {
            text-decoration: underline;
        }

    </style>


</head>
<body>
<div class="container">
        <h3>Selamat datang! <?php echo $_SESSION['user_name']; ?></h3>
        <p>Apa yang ingin kamu lakukan hari ini?</p>
        <a href="index.php">To do list?</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>