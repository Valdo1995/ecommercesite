<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

session_start();

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
    
    header('Location: cart.php');
    exit;
} else {
    header('Location: products.php');
    exit;
}
?>