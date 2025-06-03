<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

$cartItems = getCartItems($pdo);
$cartTotal = getCartTotal($pdo);
?>

<section class="cart-page">
    <h2>Your Shopping Cart</h2>
    
    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty. <a href="products.php">Continue shopping</a></p>
    <?php else: ?>
        <div class="cart-items">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td>
                                <div class="cart-product-info">
                                    <img src="/ecommerce/assets/images/products/<?php echo $item['product']['image']; ?>" alt="<?php echo $item['product']['name']; ?>">
                                    <h4><?php echo $item['product']['name']; ?></h4>
                                </div>
                            </td>
                            <td>Rp<?php echo number_format($item['product']['price'], 2); ?></td>
                            <td>
                                <form method="post" action="update-cart.php" class="update-quantity">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product']['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                    <button type="submit" class="btn-small">Update</button>
                                </form>
                            </td>
                            <td>Rp<?php echo number_format($item['product']['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <a href="remove-from-cart.php?product_id=<?php echo $item['product']['id']; ?>" class="btn-small btn-danger">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="cart-summary">
            <div class="summary-card">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp<?php echo number_format($cartTotal, 2); ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>Rp5.00</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp<?php echo number_format($cartTotal + 5, 2); ?></span>
                </div>
                <a href="checkout.php" class="btn">Proceed to Checkout</a>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>