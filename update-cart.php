<?php 
require_once 'includes/db.php';
require_once 'includes/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    if ($quantity > 0) {
        $_SESSION['cart'][$productId] = $quantity;
    } else {
        unset($_SESSION['cart'][$productId]);
    }

    header('Location: cart.php');
    exit;
} else {
    header('Location: products.php');
    exit;
}
?>
