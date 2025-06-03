<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {
    // Validate input
    $required = ['full_name', 'email', 'address', 'city', 'zip', 'card_name', 'card_number', 'expiry', 'cvv'];
    $valid = true;
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $valid = false;
            break;
        }
    }
    
    if (!$valid) {
        header('Location: checkout.php?error=missing_fields');
        exit;
    }
    
    // Process order
    $pdo->beginTransaction();
    
    try {
        // Create order
        $stmt = $pdo->prepare("
            INSERT INTO orders (customer_name, email, address, city, zip, total)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        $cartTotal = getCartTotal($pdo);
        $stmt->execute([
            $_POST['full_name'],
            $_POST['email'],
            $_POST['address'],
            $_POST['city'],
            $_POST['zip'],
            $cartTotal + 5 // $5 shipping
        ]);
        
        $orderId = $pdo->lastInsertId();
        
        // Add order items
        $cartItems = getCartItems($pdo);
        
        foreach ($cartItems as $item) {
            $stmt = $pdo->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES (?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $orderId,
                $item['product']['id'],
                $item['quantity'],
                $item['product']['price']
            ]);
        }
        
        $pdo->commit();
        
        // Clear cart
        unset($_SESSION['cart']);
        
        // Redirect to thank you page
        header('Location: order-confirmation.php?id=' . $orderId);
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        header('Location: checkout.php?error=processing_error');
        exit;
    }
} else {
    header('Location: cart.php');
    exit;
}
?>