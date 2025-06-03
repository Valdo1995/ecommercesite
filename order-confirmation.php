<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$orderId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT oi.*, p.name, p.image 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->execute([$orderId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="order-confirmation">
    <div class="confirmation-message">
        <i class="fas fa-check-circle"></i>
        <h2>Thank You for Your Order!</h2>
        <p>Your order has been placed successfully. Order ID: #<?php echo $order['id']; ?></p>
        <p>We've sent a confirmation email to <?php echo $order['email']; ?></p>
        <a href="products.php" class="btn">Continue Shopping</a>
    </div>
    
    <div class="order-details">
        <h3>Order Details</h3>
        <div class="details-row">
            <span>Order Number:</span>
            <span>#<?php echo $order['id']; ?></span>
        </div>
        <div class="details-row">
            <span>Date:</span>
            <span><?php echo date('F j, Y', strtotime($order['created_at'])); ?></span>
        </div>
        <div class="details-row">
            <span>Total:</span>
            <span>$<?php echo number_format($order['total'], 2); ?></span>
        </div>
        <div class="details-row">
            <span>Payment Method:</span>
            <span>Credit Card</span>
        </div>
        
        <h3>Shipping Information</h3>
        <p><?php echo $order['customer_name']; ?></p>
        <p><?php echo $order['address']; ?></p>
        <p><?php echo $order['city'] . ', ' . $order['zip']; ?></p>
    </div>
    
    <div class="ordered-items">
        <h3>Ordered Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <div class="product-info">
                                <img src="../ecommerce/assets/images/products/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="50">
                                <?php echo $item['name']; ?>
                            </div>
                        </td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Subtotal</td>
                    <td>$<?php echo number_format($order['total'] - 5, 2); ?></td>
                </tr>
                <tr>
                    <td colspan="3">Shipping</td>
                    <td>$5.00</td>
                </tr>
                <tr>
                    <td colspan="3">Total</td>
                    <td>$<?php echo number_format($order['total'], 2); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>