<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>

<section class="products-page">
    <h2>All Products</h2>
    <div class="filter-section">
        <form method="get">
            <select name="category">
                <option value="">All Categories</option>
                <option value="electronics">Electronics</option>
                <option value="clothing">Clothing</option>
                <option value="home">Home & Garden</option>
                <option value="computer & laptop ">Komputer & Laptop</option>
                <option value="Kamera">Kamera</option>
                <option value="Sepatu">Sepatu</option>
            </select>
            <input type="submit" value="Filter" class="btn">
        </form>
    </div>
    
    <div class="products-grid">
        <?php
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        $sql = "SELECT * FROM products";
        $params = [];
        
        if (!empty($category)) {
            $sql .= " WHERE category = '$category'";
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($products as $product): ?>
            <div class="product-card">
                <img src="/ecommerce/assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p class="price">Rp<?php echo number_format($product['price'], 2); ?></p>
                <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="btn">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>