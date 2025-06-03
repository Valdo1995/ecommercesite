<?php 
session_start();
$host = "localhost";
$db = "ecommerce";
$user = "root";
$pass = "Osvaldo1995@";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi Gagal cuy: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if($stmt->execute()) {
        $message = "Pendaftaran berhasil cuy Silahkan Login Cuy.";
    } else {
        $message ="username sudah terdaftar.";
    }

    $stmt->close();
}
$conn->close();
?> 

<!DOCTYPE html>
<html>
<head>
    <title>Register - Shopnow</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; }
        .form-container {
            width: 300px; margin: 80px auto; padding: 20px;
            background-color: white; border-radius: 10px;
            box-shadow: 0px 0px 10px #ccc;
        }
        h2 { text-align: center; }
        input[type=text], input[type=password] {
            width: 100%; padding: 10px; margin: 8px 0;
            border: 1px solid #ccc; border-radius: 5px;
        }
        input[type=submit] {
            width: 100%; background-color: #28a745;
            color: white; padding: 10px;
            border: none; border-radius: 5px; cursor: pointer;
        }
        .message { text-align: center; color: green; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <input type="submit" value="Register" />
    </form>
    <P style="text-align: center;">Sudah punya akun? <a href="login.php">Login</a></P>
     <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    </div>
    </body>
    </html>



