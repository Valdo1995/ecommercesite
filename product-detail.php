<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$product = getProductById($pdo, $_GET['id']);

if (!$product) {
    header('Location: products.php');
    exit;
}

require_once 'includes/header.php';
?>

<section class="product-detail">
    <div class="product-images">
        <img src="../ecommerce/assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    </div>
    <div class="product-info">
        <h1><?php echo $product['name']; ?></h1>
        <p class="price">Rp<?php echo number_format($product['price'], 2); ?></p>
        <p class="description"><?php echo $product['description']; ?></p>
        
        <form method="post" action="add-to-cart.php">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <div class="quantity-selector">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1">
            </div>
            <button type="submit" class="btn">Add to Cart</button>
        </form>
    </div>
</section>

<section class="related-products">
    <h2>You May Also Like</h2>
    <div class="products-grid">
        <?php
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ? AND id != ? LIMIT 4");
        $stmt->execute([$product['category'], $product['id']]);
        $relatedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($relatedProducts as $related): ?>
            <div class="product-card">
                <img src="../ecommerce/assets/images/products/<?php echo $related['image']; ?>" alt="<?php echo $related['name']; ?>">
                <h3><?php echo $related['name']; ?></h3>
                <p class="price">Rp<?php echo number_format($related['price'], 2); ?></p>
                <a href="product-detail.php?id=<?php echo $related['id']; ?>" class="btn">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>