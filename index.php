<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <h2>Welcome to ShopNow</h2>
        <p>Discover amazing products at unbeatable prices</p>
        <a href="products.php" class="btn">Shop Now</a>
    </div>
</section>

<section class="featured-products">
    <h2>Featured Products</h2>
    <div class="products-grid">
        <?php
        $products = getProducts($pdo);
        foreach ($products as $product): ?>
            <div class="product-card">
                <img src="/assets/images/products/product1.jpg" alt="Smartphone X"><?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p class="price">?<?php echo number_format($product['price'], 2); ?></p>
                <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="btn">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>