<?php 
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

$cartItems = getCartItems($pdo);
$cartTotal = getCartTotal($pdo);

if (empty($cartItems)) {
    header('Location: cart.php');
    exit;
}
?> 

<section class="checkout-page">
    <h2>Checkout</h2>

    <div class="checkout-container">
        <div class="checkout-form">
            <form method="post" action="process-order.php">
                <h3>Shipping Information</h3>
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required> 
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>
                </div>
                <div class="form-group">
                    <label for="zip">ZIP Code</label>
                    <input type="text" id="zip" name="zip"  required>
                </div>

                <h3>Payment Information</h3>
                <div class="form-group">
                    <label for="card_name">Name On Card</label>
                    <input type="text" id="card_name" name="card_name" required>
                </div>
                <div class="form-group">
                    <label for="card_number">Card Number</label>
                    <input type="text" id="card_number" name="card_number" required>
                </div>
                <div class="form-group">
                    <label for="expiry">Expiry Date</label>
                    <input type="text" id="cvv" name="cvv" required> 
                </div>
                </div>

                <button type="submit" class="btn">Place Order</button>
            </form>
            </div>

            <div class="order-summary">
                <h3>Your Order</h3>
                <div class="order-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="order-item"> 
                            <span><?php echo $item['product']['name']; ?></span>
                            <span>x<?php echo $item['quantity']; ?></span>
                        </div>
                        <div class="item-price"> 
                            $<?php echo number_format($item['product']['price'] * $item['quantity'],2); ?> 
                        </div>
                </div>
                <?php endforeach; ?> 
                </div>
                <div class="order-totals">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>$<?php echo number_format($cartTotal, 2); ?></span>
                    </div>
                    <div class="total-row">
                        <span>Shipping</span>
                        <span>$5.00</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total</span>
                        <span>$<?php echo number_format($cartTotal + 5, 2); ?></span>
                        </div>
                        </div>
                    </div>
                    </div>
                    </section>

                    <?php require_once 'includes/footer.php'; ?>
                    