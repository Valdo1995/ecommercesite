<?php 
session_start();
$host="localhost";
$db="ecommerce";
$user="root";
$pass="Osvaldo1995@";
$conn= new mysqli($host, $user, $pass, $db);

if($conn->connect_error) {
    die("Koneksi gagal cuy: " . $conn->connect_error);
}

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if(password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $id;
            header("Location: products.php");
            exit();
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ada.";
    }

    $stmt->close();
}
$conn->close();
?> 

<p style="text-align:center;">Belum ada akun? <a href="register.php">Register</a></p>