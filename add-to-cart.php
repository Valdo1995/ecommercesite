<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    addToCart($productId, $quantity);
    
    header('Location: cart.php');
    exit;
} else {
    header('Location: products.php');
    exit;
}
?>